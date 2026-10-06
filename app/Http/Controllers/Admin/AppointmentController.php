<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Appointment, User};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentStatusUpdated;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       if (Auth::user()->user_type === User::ROLE['agency']) {
            $appointments = Appointment::where('salon', Auth::id())->latest()->paginate(20);
        } else {
            $appointments = Appointment::latest()->paginate(20);
        }

        return view('admin.appointment.appointment_book', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);

        return view('admin.appointment.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
     public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $appointment = Appointment::findOrFail($id);
        $oldStatus = $appointment->status;
        $appointment->status = $request->status;
        $appointment->save();

        // Send email notification
        if ($oldStatus != $request->status) {
            try {
                Mail::to($appointment->email)->send(new AppointmentStatusUpdated($appointment, $oldStatus));
            } catch (\Exception $e) {
                \Log::error('Failed to send appointment status email: ' . $e->getMessage());
            }
        }

        // Return response based on request type
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'new_status' => $appointment->status,
                'status_label' => ucfirst($appointment->status)
            ]);
        }

        return redirect()->back()->with('success', 'Appointment status updated successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'service' => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $appointment = Appointment::findOrFail($id);
        $oldStatus = $appointment->status;
        
        $appointment->update($request->all());

        // Send email if status changed
        if ($oldStatus != $request->status) {
            try {
                Mail::to($appointment->email)->send(new AppointmentStatusUpdated($appointment, $oldStatus));
            } catch (\Exception $e) {
                \Log::error('Failed to send appointment status email: ' . $e->getMessage());
            }
        }

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully!');
    }
}
