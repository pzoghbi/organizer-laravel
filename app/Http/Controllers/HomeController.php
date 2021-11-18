<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Check if the user has set up Studies
        // Check if the user has set up schedule
        return view('home');
    }

    public function showDashboard()
    {
        $schedule = \App\Models\Schedule::where('user_id', auth()->id())->where('is_active', true)->first();
        $tasks = \App\Models\Task::where('user_id', auth()->id())->take(5)->orderBy('datetime', 'desc')->get();

        return View('home')->with([
            'schedule' => $schedule,
            'tasks' => $tasks,
//            'materials' => $materials
        ]);
    }
}
