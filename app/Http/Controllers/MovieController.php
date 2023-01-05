<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MovieController extends Controller
{
    // Show all movies
    public function index() {
        $movies = Movie::latest('updated_at')->get();

        return response()->json($movies);
    }

    // Show all movies title ascending
    public function indexTitleAscending() {
        $movies = Movie::orderBy('title', 'asc')->get();

        return response()->json($movies);
    }

    // Show single cinema
    public function show(Movie $movie) {
        return response()->json($movie);
    }

    // Store movies data
    public function store(Request $request) {
        // Validation
        $formFields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'rating' => 'required',
            'genre' => 'required',
            'hour' => 'required',
            'minute' => 'required',
            'showing_date' => 'required',
            'end_date' => 'required',
        ]);

        // For Image
        if ($request->hasFile('poster')) {
            $formFields['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $movie = Movie::create($formFields);

        if ($movie) {
            return response()->json([
                'success' => 'Movie created successfully'
            ], 201);
        }
    }

    // Show movie update form
    public function edit(Movie $movie) {
        return response()->json($movie);
    }

    // Update movie data
    public function update(Request $request, Movie $movie) {
        // Validation
        $formFields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'rating' => 'required',
            'genre' => 'required',
            'hour' => 'required',
            'minute' => 'required',
            'showing_date' => 'required',
            'end_date' => 'required',
        ]);

        // For Image
        if ($request->hasFile('poster')) {
            $formFields['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $movie->update($formFields);

        if ($movie) {
            return response()->json([
                'success' => 'Movie updated successfully'
            ], 200);
        }
    }

    // Delete movie data
    public function destroy(Movie $movie) {
        $movie->delete();

        if ($movie) {
            return response()->json([
                'success' => 'Movie deleted successfully'
            ], 200);
        }
    }

}
