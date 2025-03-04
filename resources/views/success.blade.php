<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booked</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Appointment Booked Successfully!</h1>
        <p>Thank you for booking with us.</p>
        <a href="{{ route('booking.form') }}" class="btn btn-primary">Book Another Appointment</a>
    </div>
</body>
</html>
