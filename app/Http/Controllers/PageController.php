<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // Show home page
    public function index() {
        return view('index');
    }

    // // Show safety protocols & guidelines page
    // public function safety() {
    //     return view('pages.safety');
    // }

    // // Show schedules page
    // public function schedules() {
    //     return view('pages.schedules');
    // }

    // // Show contact page
    // public function contact() {
    //     return view('pages.contact');
    // }
}
