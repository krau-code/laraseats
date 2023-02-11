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

// Show all movies
Route::get('/site/movies', [MovieController::class, 'index']);

// Show single movie
Route::get('/site/movies/{movie}', [MovieController::class, 'show']);

// Show formatted schedules
Route::get('/site/schedules/byMovie/{movieId}', [ScheduleController::class, 'getByMovie']);

// Show formatted schedules
Route::get('/site/schedules/getByDate/{chosenDate}', [ScheduleController::class, 'getByDate']);

// Show all schedules
Route::get('/site/schedules/all', [ScheduleController::class, 'index']);

// Update schedule seat_left data
Route::put('/site/schedules/updateSeat/{schedule}', [ScheduleController::class, 'updateSeat']);

// Store resrvations data
Route::post('/site/reservations/create', [ReservationController::class, 'store']);

// Show single schedule
Route::get('/site/schedules/{schedule}', [ScheduleController::class, 'show']);

// --------------------------------------------------
// ADMIN 

// Show admin login form
Route::get('/admin/login', [AdminController::class, 'adminLogin'])
    ->name('adminLogin')
    ->middleware('guest');

// Create new admin
Route::post('/admin/create', [AdminController::class, 'adminCreate'])
    ->name('adminCreate')
    ->middleware('guest');

// Log out admin
Route::post('/admin/logout', [AdminController::class, 'adminLogout'])
    ->name('adminLogout')
    ->middleware('auth');

// Log in admin
Route::post('/admin/authenticate', [AdminController::class, 'adminAuthenticate'])
    ->name('adminAuthenticate')
    ->middleware('guest');

// Show admin page
Route::get('/admin', [AdminController::class, 'adminIndex'])
    ->name('adminIndex')
    ->middleware('auth');

// --------------------------------------------------
// MOVIES

// Show all movies
Route::get('/admin/movies/data', [MovieController::class, 'index'])
    ->name('moviesIndex')
    ->middleware('auth');

// Show all movies title ascending
Route::get('/admin/movies/titleAscending', [MovieController::class, 'indexTitleAscending'])
    ->name('moviesIndexTitleAscending')
    ->middleware('auth');

// Store movie data
Route::post('/admin/movies/create', [MovieController::class, 'store'])
    ->name('moviesCreate')
    ->middleware('auth');

// Show movie update form
Route::get('/admin/movies/data/{movie}/edit', [MovieController::class, 'edit'])
    ->name('moviesEdit')
    ->middleware('auth');

// Update movie data
Route::put('/admin/movies/{movie}', [MovieController::class, 'update'])
    ->name('moviesUpdate')
    ->middleware('auth');

// Delete movie data
Route::delete('/admin/movies/{movie}', [MovieController::class, 'destroy'])
    ->name('moviesDelete')
    ->middleware('auth');

// Show single movie
Route::get('/admin/movies/data/{movie}', [MovieController::class, 'show'])
    ->name('schedulesShow')
    ->middleware('auth');

// --------------------------------------------------
// CINEMAS

// Show all cinemas
Route::get('/admin/cinemas/data', [CinemaController::class, 'index'])
    ->name('cinemasIndex')
    ->middleware('auth');

// Show all cinemas title ascending
Route::get('/admin/cinemas/nameAscending', [CinemaController::class, 'indexNameAscending'])
    ->name('cinemasIndexNameAscending')
    ->middleware('auth');

// Store cinema data
Route::post('/admin/cinemas/create', [CinemaController::class, 'store'])
    ->name('cinemasCreate')
    ->middleware('auth');

// Show cinema update form
Route::get('/admin/cinemas/data/{cinema}/edit', [CinemaController::class, 'edit'])
    ->name('cinemasEdit')
    ->middleware('auth');

// Update cinema data
Route::put('/admin/cinemas/{cinema}', [CinemaController::class, 'update'])
    ->name('cinemasUpdate')
    ->middleware('auth');

// Update cinema data
Route::delete('/admin/cinemas/{cinema}', [CinemaController::class, 'destroy'])
    ->name('cinemasDelete')
    ->middleware('auth');

// Get single cinema data
Route::get('/admin/cinemas/{cinemas}', [CinemaController::class, 'show'])
    ->name('cinemasShow')
    ->middleware('auth');

// --------------------------------------------------
// SCHEDULES

// Show formatted schedules
Route::get('/admin/schedules/data', [ScheduleController::class, 'indexDisplay'])
    ->name('schedulesIndexDisplay')
    ->middleware('auth');

// Show all schedules
Route::get('/admin/schedules/all', [ScheduleController::class, 'index'])
    ->name('schedulesIndex')
    ->middleware('auth');

// Show formatted schedules
Route::get('/admin/schedules/byDate', [ScheduleController::class, 'indexByDate'])
    ->name('schedulesIndexByDate')
    ->middleware('auth');

// Show formatted schedules
Route::get('/admin/schedules/byMovie/{movieId}', [ScheduleController::class, 'getByMovie'])
    ->name('schedulesIndexByMovie')
    ->middleware('auth');

// Show formatted schedules
Route::get('/admin/schedules/getByDate/{chosenDate}', [ScheduleController::class, 'getByDate'])
    ->name('schedulesGetByDate')
    ->middleware('auth');

// Store schedules data
Route::post('/admin/schedules/create', [ScheduleController::class, 'store'])
    ->name('schedulesCreate')
    ->middleware('auth');

// Show schedule update form
Route::get('/admin/schedules/data/{schedule}/edit', [ScheduleController::class, 'edit'])
    ->name('schedulesEdit')
    ->middleware('auth');

// Update schedule data
Route::put('/admin/schedules/{schedule}', [ScheduleController::class, 'update'])
    ->name('schedulesUpdate')
    ->middleware('auth');

// Update schedule seat_left data
Route::put('/admin/schedules/updateSeat/{schedule}', [ScheduleController::class, 'updateSeat'])
    ->name('schedulesUpdateSeat')
    ->middleware('auth');

// Delete schedule data
Route::delete('/admin/schedules/{schedule}', [ScheduleController::class, 'destroy'])
    ->name('schedulesDelete')
    ->middleware('auth');

// Show single schedule
Route::get('/admin/schedules/{schedule}', [ScheduleController::class, 'show'])
    ->name('schedulesShow')
    ->middleware('auth');

// --------------------------------------------------
// RESERVATION

// Show formatted resrvations
Route::get('/admin/reservations/data', [ReservationController::class, 'indexDisplay'])
    ->name('reservationsIndexDisplay')
    ->middleware('auth');

// Show all resrvations
Route::get('/admin/reservations/all', [ReservationController::class, 'index'])
    ->name('reservationsIndex')
    ->middleware('auth');

// Store resrvations data
Route::post('/admin/reservations/create', [ReservationController::class, 'store'])
    ->name('reservationsCreate')
    ->middleware('auth');

// Show resrvations update form
Route::get('/admin/reservations/data/{reservation}/edit', [ReservationController::class, 'edit'])
    ->name('reservationsEdit')
    ->middleware('auth');

// Update reservations data
Route::put('/admin/reservations/{reservation}', [ReservationController::class, 'update'])
    ->name('reservationsUpdate')
    ->middleware('auth');

// Delete reservations data
Route::delete('/admin/reservations/{reservation}', [ReservationController::class, 'destroy'])
    ->name('reservationsDelete')
    ->middleware('auth');

// --------------------------------------------------

// Anything than above for admin
Route::view('/admin/{any}', 'adminIndex')
    ->middleware('auth')
    ->where('any', '.*');

// Anything than above for pages
Route::view('/{any}', 'index')
    ->where('any', '.*');

