<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use App\Services\AcuityService;

class AcuityController extends Controller
{
    protected $acuityService;

    public function __construct(AcuityService $acuityService)
    {
        $this->acuityService = $acuityService;
    }

    /**
     * Display the appointment booking form.
     */
    public function showBookingForm()
    {
        // Fetch appointment types to populate the form dropdown
        $appointmentTypes = $this->acuityService->getAppointmentTypes();
        return view('booking-form', compact('appointmentTypes'));
    }

    /**
     * Handle the appointment booking form submission.
     */
    public function bookAppointment(Request $request)
{
    // Validate the form data
    $data = $request->validate([
        'appointmentTypeID' => 'required|integer',
        'date' => 'required|date',
        'time' => 'required|string',
        'firstName' => 'required|string',
        'lastName' => 'required|string',
        'email' => 'required|email',
    ]);

    // Use the time value directly (it already contains the full datetime)
    $data['datetime'] = $data['time'];

    // Log the data being sent to Acuity
    \Log::info('Appointment Data:', $data);

    // Create the appointment using AcuityService
    $appointment = $this->acuityService->createAppointment($data);

    // Log the API response
    \Log::info('Acuity API Response:', $appointment);

    // Redirect back with a success or error message
    if (isset($appointment['error'])) {
        return redirect()->back()->with('error', $appointment['error']);
    }

    return redirect()->back()->with('success', 'Appointment booked successfully!');
}

    /**
     * Fetch available appointment times.
     */
    public function getAvailability(Request $request)
    {
        $request->validate([
            'appointmentTypeID' => 'required|integer',
            'date' => 'nullable|date',
        ]);

        $appointmentTypeId = $request->input('appointmentTypeID');
        $date = $request->input('date');

        $availability = $this->acuityService->getAvailability($appointmentTypeId, $date);

        if (isset($availability['error'])) {
            return response()->json(['error' => $availability['error']], 400);
        }

        return response()->json($availability);
    }

    public function getUserAppointments(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email',
        ]);

        // Fetch appointments by email
        $appointments = $this->acuityService->getAppointmentsByEmail($request->input('email'));

        // Check for errors
        if (isset($appointments['error'])) {
            return response()->json(['error' => $appointments['error']], 400);
        }

        // Return the appointments as JSON
        return response()->json($appointments);
    }
}
