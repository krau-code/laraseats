<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --------------------------------------------------
// PAGES

// Show home page
Route::get('/', [PageController::class, 'index'])->name('index');

// SITE ~ "/site/{link}"
Route::group(['prefix' => 'site'], function () {
    
    // Show all movies
    Route::get('movies', [MovieController::class, 'index']);

    // Show single movie
    Route::get('movies/{movie}', [MovieController::class, 'show']);

    // Show formatted schedules
    Route::get('schedules/byMovie/{movieId}', [ScheduleController::class, 'getByMovie']);

    // Show formatted schedules
    Route::get('schedules/getByDate/{chosenDate}', [ScheduleController::class, 'getByDate']);

    // Show all schedules
    Route::get('schedules/all', [ScheduleController::class, 'index']);

    // Update schedule seat_left data
    Route::put('schedules/updateSeat/{schedule}', [ScheduleController::class, 'updateSeat']);

    // Store resrvations data
    Route::post('reservations/create', [ReservationController::class, 'store']);

    // Show single schedule
    Route::get('schedules/{schedule}', [ScheduleController::class, 'show']);
});

// --------------------------------------------------

// GUEST
Route::group(['middleware' => 'guest'], function() {

    // Show admin login form
    Route::get('/admin/login', [AdminController::class, 'adminLogin'])
    ->name('adminLogin');

    // Create new admin
    Route::post('/admin/create', [AdminController::class, 'adminCreate'])
    ->name('adminCreate');

    // Log in admin
    Route::post('/admin/authenticate', [AdminController::class, 'adminAuthenticate'])
    ->name('adminAuthenticate');
});

// AUTH
Route::group(['middleware' => 'auth'], function() {

    // ADMIN ~ "/admin/{link}"
    Route::group(['prefix' => 'admin'], function() {

        // Log out admin
        Route::post('logout', [AdminController::class, 'adminLogout'])
            ->name('adminLogout')
            ->middleware('auth');

        // Show admin page
        Route::get('/', [AdminController::class, 'adminIndex'])
            ->name('adminIndex')
            ->middleware('auth');

        // MOVIES ~ "/admin/movies/{link}"
        Route::group(['prefix' => 'movies'], function() {

            // Show all movies
            Route::get('data', [MovieController::class, 'index'])
                ->name('moviesIndex');
            
            // Show all movies title ascending
            Route::get('titleAscending', [MovieController::class, 'indexTitleAscending'])
                ->name('moviesIndexTitleAscending');
            
            // Store movie data
            Route::post('/admin/movies/create', [MovieController::class, 'store'])
                ->name('moviesCreate');
            
            // Show movie update form
            Route::get('data/{movie}/edit', [MovieController::class, 'edit'])
                ->name('moviesEdit');
            
            // Update movie data
            Route::put('{movie}', [MovieController::class, 'update'])
                ->name('moviesUpdate');
            
            // Delete movie data
            Route::delete('{movie}', [MovieController::class, 'destroy'])
                ->name('moviesDelete');
            
            // Show single movie
            Route::get('data/{movie}', [MovieController::class, 'show'])
                ->name('schedulesShow');
        });

        // CINEMAS ~ "/admin/cinemas/{link}"
        Route::group(['prefix' => 'cinemas'], function() {

            // Show all cinemas
            Route::get('data', [CinemaController::class, 'index'])
                ->name('cinemasIndex');

            // Show all cinemas title ascending
            Route::get('nameAscending', [CinemaController::class, 'indexNameAscending'])
                ->name('cinemasIndexNameAscending');

            // Store cinema data
            Route::post('create', [CinemaController::class, 'store'])
                ->name('cinemasCreate');

            // Show cinema update form
            Route::get('data/{cinema}/edit', [CinemaController::class, 'edit'])
                ->name('cinemasEdit');

            // Update cinema data
            Route::put('{cinema}', [CinemaController::class, 'update'])
                ->name('cinemasUpdate');

            // Update cinema data
            Route::delete('{cinema}', [CinemaController::class, 'destroy'])
                ->name('cinemasDelete');

            // Get single cinema data
            Route::get('{cinemas}', [CinemaController::class, 'show'])
                ->name('cinemasShow');
        });

        // SCHEDULES ~ "/admin/schedules/{link}"
        Route::group(['prefix' => 'schedules'], function() {

            // Show formatted schedules
            Route::get('data', [ScheduleController::class, 'indexDisplay'])
                ->name('schedulesIndexDisplay');

            // Show all schedules
            Route::get('all', [ScheduleController::class, 'index'])
                ->name('schedulesIndex');

            // Show formatted schedules
            Route::get('byDate', [ScheduleController::class, 'indexByDate'])
                ->name('schedulesIndexByDate');

            // Show formatted schedules
            Route::get('byMovie/{movieId}', [ScheduleController::class, 'getByMovie'])
                ->name('schedulesIndexByMovie');

            // Show formatted schedules
            Route::get('getByDate/{chosenDate}', [ScheduleController::class, 'getByDate'])
                ->name('schedulesGetByDate');

            // Store schedules data
            Route::post('create', [ScheduleController::class, 'store'])
                ->name('schedulesCreate');

            // Show schedule update form
            Route::get('data/{schedule}/edit', [ScheduleController::class, 'edit'])
                ->name('schedulesEdit');

            // Update schedule data
            Route::put('{schedule}', [ScheduleController::class, 'update'])
                ->name('schedulesUpdate');

            // Update schedule seat_left data
            Route::put('updateSeat/{schedule}', [ScheduleController::class, 'updateSeat'])
                ->name('schedulesUpdateSeat');

            // Delete schedule data
            Route::delete('{schedule}', [ScheduleController::class, 'destroy'])
                ->name('schedulesDelete');

            // Show single schedule
            Route::get('{schedule}', [ScheduleController::class, 'show'])
                ->name('schedulesShow');
        });

        // RESERVATION
        Route::group(['prefix' => 'reservations'], function() {
       
            // Show formatted resrvations
            Route::get('data', [ReservationController::class, 'indexDisplay'])
            ->name('reservationsIndexDisplay');

            // Show all resrvations
            Route::get('all', [ReservationController::class, 'index'])
            ->name('reservationsIndex');

            // Store resrvations data
            Route::post('create', [ReservationController::class, 'store'])
            ->name('reservationsCreate');

            // Show resrvations update form
            Route::get('data/{reservation}/edit', [ReservationController::class, 'edit'])
            ->name('reservationsEdit');

            // Update reservations data
            Route::put('{reservation}', [ReservationController::class, 'update'])
            ->name('reservationsUpdate');

            // Delete reservations data
            Route::delete('{reservation}', [ReservationController::class, 'destroy'])
            ->name('reservationsDelete');
        });

        // Anything than above for admin
        Route::view('{any}', 'adminIndex')
            ->where('any', '.*');

    }); // End - ADMIN 
});

// Anything than above for pages
Route::view('/{any}', 'index')
    ->where('any', '.*');
