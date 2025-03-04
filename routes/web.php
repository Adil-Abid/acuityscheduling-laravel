<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcuityController;


Route::get('/', function () {
    return view('welcome');
});

// Show the booking form
Route::get('/booking', [AcuityController::class, 'showBookingForm'])->name('booking.form');

// Handle the booking form submission
Route::post('/booking', [AcuityController::class, 'bookAppointment'])->name('book.appointment');

// Fetch availability (for AJAX requests)
Route::get('/availability', [AcuityController::class, 'getAvailability']);

Route::get('/user-appointments', [AcuityController::class, 'getUserAppointments']);

Route::get('/view-appointments', function () {
    return view('user-appointments');
});
