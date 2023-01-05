<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    // Show formatted schedule
    public function indexDisplay() {
        $reservations = DB::table('reservations')
            ->select('reservations.id as id', 'schedules.date as date', 'movies.title as title', 'cinemas.cinema_name as cinema_name', 'schedules.amount as amount', 'reservations.quantity as quantity', 'reservations.total_amount as total_amount', 'reservations.name as name', 'reservations.email as email', 'reservations.schedule_id as schedule_id')
            ->leftJoin('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->leftJoin('movies', 'schedules.movie_id', '=' ,'movies.id')
            ->leftJoin('cinemas', 'schedules.cinema_id', '=', 'cinemas.id')
            ->orderBy('reservations.updated_at', 'desc')
            ->get();

        return response()->json($reservations);
    }

    // Show all schedules
    public function index() {
        $reservations = Reservation::all();

        return response()->json($reservations);
    }

    // Store schedule data
    public function store(Request $request) {
        // Validation
        $formFields = $request->validate([
            'schedule_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'quantity' => 'required',
            'total_amount' => 'required',
        ]);

        $reservation = Reservation::create($formFields);

        if ($reservation) {
            return response()->json([
                'success' => 'Schedule created successfully'
            ], 201);
        }
    }

    // Show schedule update form
    public function edit(Reservation $reservation) {
        return response()->json($reservation);
    }

    // Update schedule data
    public function update(Request $request, Reservation $reservation) {
        // Validation
        $formFields = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $reservation->update($formFields);

        if ($reservation) {
            return response()->json([
                'success' => 'Cinema updated successfully'
            ], 200);
        }
    }

    // Delete cinema data
    public function destroy(Reservation $reservation) {
        $reservation->delete();

        if ($reservation) {
            return response()->json([
                'success' => 'Schedule deleted successfully'
            ], 200);
        }
    }
}
