<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    // Show formatted schedule
    public function indexDisplay() {
        $schedules = DB::table('schedules')
            ->select('schedules.id as id','schedules.date as date', 'movies.title as title', 'movies.poster as poster', 'movies.hour as hour', 'movies.minute as minute', 'cinemas.cinema_name as cinema_name', 'schedules.seat_left', 'cinemas.seating_capacity', 'schedules.amount as amount', 'cinemas.id as cinema_id', 'movies.id as movie_id')
            ->leftJoin('movies', 'schedules.movie_id', '=' ,'movies.id')
            ->leftJoin('cinemas', 'schedules.cinema_id', '=', 'cinemas.id')
            ->orderBy('schedules.updated_at', 'desc')
            ->get();

        return response()->json($schedules);
    }

    // Show all schedules
    public function index() {
        $schedules = Schedule::all();

        return response()->json($schedules);
    }

    // Show formatted schedule
    public function indexByDate() {
        $schedules = DB::table('schedules')
            ->select('schedules.id as id','schedules.date as date', 'movies.title as title', 'movies.poster as poster', 'movies.hour as hour', 'movies.minute as minute', 'cinemas.cinema_name as cinema_name', 'schedules.seat_left', 'cinemas.seating_capacity', 'schedules.amount as amount', 'cinemas.id as cinema_id', 'movies.id as movie_id')
            ->leftJoin('movies', 'schedules.movie_id', '=' ,'movies.id')
            ->leftJoin('cinemas', 'schedules.cinema_id', '=', 'cinemas.id')
            ->orderBy('schedules.date', 'asc')
            ->get();

        return response()->json($schedules);
    }

    // Show formatted schedule
    public function getByMovie($movieId) {
        $schedules = DB::table('schedules')
            ->select('schedules.id as id','schedules.date as date', 'movies.title as title', 'movies.poster as poster', 'movies.hour as hour', 'movies.minute as minute', 'cinemas.cinema_name as cinema_name', 'schedules.seat_left', 'cinemas.seating_capacity', 'schedules.amount as amount', 'cinemas.id as cinema_id', 'movies.id as movie_id')
            ->leftJoin('movies', 'schedules.movie_id', '=' ,'movies.id')
            ->leftJoin('cinemas', 'schedules.cinema_id', '=', 'cinemas.id')
            ->where('schedules.movie_id', $movieId)
            ->orderBy('schedules.date', 'asc')
            ->orderBy('cinemas.cinema_name')
            ->get();

        return response()->json($schedules);
    }

    // Show formatted schedule
    public function getByDate($chosenDate) {
        $schedules = DB::table('schedules')
            ->select('schedules.id as id','schedules.date as date', 'movies.title as title', 'movies.poster as poster', 'movies.hour as hour', 'movies.minute as minute', 'cinemas.cinema_name as cinema_name', 'schedules.seat_left', 'cinemas.seating_capacity', 'schedules.amount as amount', 'cinemas.id as cinema_id', 'movies.id as movie_id')
            ->leftJoin('movies', 'schedules.movie_id', '=' ,'movies.id')
            ->leftJoin('cinemas', 'schedules.cinema_id', '=', 'cinemas.id')
            ->where('schedules.date', $chosenDate)
            ->orderBy('movies.title', 'asc')
            ->orderBy('cinemas.cinema_name')
            ->get();

        return response()->json($schedules);
    }
    
    // Show single schedule
    public function show($schedule) {
        $data = DB::table('schedules')
            ->select('schedules.id as id','schedules.date as date', 'movies.title as title', 'movies.poster as poster', 'movies.hour as hour', 'movies.minute as minute', 'cinemas.cinema_name as cinema_name', 'schedules.seat_left', 'cinemas.seating_capacity', 'schedules.amount as amount', 'cinemas.id as cinema_id', 'movies.id as movie_id')
            ->leftJoin('movies', 'schedules.movie_id', '=' ,'movies.id')
            ->leftJoin('cinemas', 'schedules.cinema_id', '=', 'cinemas.id')
            ->where('schedules.id', $schedule)
            ->orderBy('schedules.updated_at', 'desc')
            ->get();

        return response()->json($data);
    }

    // Store schedule data
    public function store(Request $request) {
        // Validation
        $formFields = $request->validate([
            'movie_id' => 'required',
            'cinema_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'seat_left' => 'required',
        ]);

        $schedule = Schedule::create($formFields);

        if ($schedule) {
            return response()->json([
                'success' => 'Schedule created successfully'
            ], 201);
        }
    }

    // Show schedule update form
    public function edit(Schedule $schedule) {
        return response()->json($schedule);
    }

    // Update schedule data
    public function update(Request $request, Schedule $schedule) {
        // Validation
        $formFields = $request->validate([
            'movie_id' => 'required',
            'cinema_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'seat_left' => 'required',
        ]);

        $schedule->update($formFields);

        if ($schedule) {
            return response()->json([
                'success' => 'Schedule updated successfully'
            ], 200);
        }
    }

    // Update seat data
    public function updateSeat(Request $request, Schedule $schedule) {
        // Validation
        $formFields = $request->validate([
            'seat_left' => 'required',
        ]);

        $schedule->update($formFields);

        if ($schedule) {
            return response()->json([
                'message' => 'Seat left updated successfully'
            ], 200);
        }
    }

    // Delete cinema data
    public function destroy(Schedule $schedule) {
        $schedule->delete();

        if ($schedule) {
            return response()->json([
                'success' => 'Schedule deleted successfully'
            ], 200);
        }
    }
}
