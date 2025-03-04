<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">User Appointments</h1>

        <form id="fetchAppointmentsForm">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Fetch Appointments</button>
        </form>

        <div id="appointmentsList" class="mt-4"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#fetchAppointmentsForm').on('submit', function (e) {
                e.preventDefault();

                const email = $('#email').val();

                $.get('/user-appointments', { email }, function (data) {
                    if (data.error) {
                        $('#appointmentsList').html(`<div class="alert alert-danger">${data.error}</div>`);
                    } else if (data.length === 0) {
                        $('#appointmentsList').html('<div class="alert alert-info">No appointments found.</div>');
                    } else {
                        let html = '<ul class="list-group">';
                        data.forEach(appointment => {
                            console.log(appointment);
                            html += `
                                <li class="list-group-item">
                                    <strong>Appointment ID:</strong> ${appointment.id}<br>
                                    <strong>Date:</strong> ${appointment.datetime}<br>
                                    <strong>Duration:</strong> ${appointment.duration}<br>
                                    <strong>Type:</strong> ${appointment.firstName}<br>
                                    <strong>email:</strong> ${appointment.email}<br>
                                    <strong>Calendar:</strong> ${appointment.calendar.name}
                                </li>
                            `;
                        });
                        html += '</ul>';
                        $('#appointmentsList').html(html);
                    }
                }).fail(function (error) {
                    $('#appointmentsList').html(`<div class="alert alert-danger">Error fetching appointments.</div>`);
                });
            });
        });
    </script>
</body>
</html>
