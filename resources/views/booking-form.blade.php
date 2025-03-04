<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Book an Appointment</h1>
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('book.appointment') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="appointmentTypeID" class="form-label">Appointment Type</label>
                <select class="form-select" id="appointmentTypeID" name="appointmentTypeID" required>
                    <option value="">Select an appointment type</option>
                    @foreach($appointmentTypes as $type)
                        <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <div class="mb-3">
                <label for="time" class="form-label">Time</label>
                <select class="form-select" id="time" name="time" required>
                    <option value="">Select a time</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>

            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </form>
        {{-- <form action="{{ route('book.appointment') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="appointmentTypeID" class="form-label">Appointment Type</label>
                <select class="form-select" id="appointmentTypeID" name="appointmentTypeID" required>
                    <option value="">Select an appointment type</option>
                    @foreach($appointmentTypes as $type)
                        <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <div class="mb-3">
                <label for="time" class="form-label">Time</label>
                <select class="form-select" id="time" name="time" required>
                    <option value="">Select a time</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>

            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </form> --}}
    </div>

    <script>
       $(document).ready(function () {
            // Fetch available times when the date or appointment type changes
            $('#appointmentTypeID, #date').change(function () {
                const appointmentTypeID = $('#appointmentTypeID').val();
                const date = $('#date').val();

                if (appointmentTypeID && date) {
                    $.get('/availability', { appointmentTypeID, date }, function (data) {
                        $('#time').empty().append('<option value="">Select a time</option>');
                        if (data.length > 0) {
                            data.forEach(time => {
                                $('#time').append(`<option value="${time.time}">${time.time}</option>`);
                            });
                        } else {
                            $('#time').append('<option value="">No available times</option>');
                        }
                    }).fail(function (error) {
                        console.error('Error fetching availability:', error);
                    });
                }
            });
        });
    </script>
</body>
</html>
