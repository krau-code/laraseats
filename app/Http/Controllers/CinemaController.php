<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CinemaController extends Controller
{
    // Show all cinemas
    public function index() {
        $cinemas = Cinema::latest('updated_at')->get();

        return response()->json($cinemas);
    }

    // Show all movies title ascending
    public function indexNameAscending() {
        $movies = Cinema::orderBy('cinema_name', 'asc')->get();

        return response()->json($movies);
    }

    // Show single cinema
    public function show(Cinema $cinemas) {
        return response()->json($cinemas);
    }

    // Store cinemas data
    public function store(Request $request) {
        // Validation
        $formFields = $request->validate([
            'cinema_name' => 'required',
            'seating_capacity' => 'required',
        ]);

        $cinema = Cinema::create($formFields);

        if ($cinema) {
            return response()->json([
                'success' => 'Cinema created successfully'
            ], 201);
        }
    }

    // Show cinema update form
    public function edit(Cinema $cinema) {
        return response()->json($cinema);
    }

    // Update cinema data
    public function update(Request $request, Cinema $cinema) {
        // Validation
        $formFields = $request->validate([
            'cinema_name' => 'required',
        ]);

        $cinema->update($formFields);

        if ($cinema) {
            return response()->json([
                'success' => 'Cinema updated successfully'
            ], 200);
        }
    }

    // Delete cinema data
    public function destroy(Cinema $cinema) {
        $cinema->delete();

        if ($cinema) {
            return response()->json([
                'success' => 'Cinema deleted successfully'
            ], 200);
        }
    }

}
