<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function dashboardView():View{

        return view('pages.Dashboard.dashboard');

    } 
}
