<?php

namespace App\Http\Controllers;

use DateTime;
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
        $schedule->groupLectures = $schedule->groupLectures();
        foreach ($schedule->groupLectures as $day => $lecture_group) {
            foreach ($lecture_group as $lecture) {
                $lecture->start = date('H:i', strtotime($lecture->start));
                $lecture->end = date('H:i', strtotime($lecture->end));
                $lecture->subject = $lecture->subject()->first();
            }
        }

        $tasks = \App\Models\Task::where('user_id', auth()->id())->take(5)->orderBy('datetime', 'desc')->get();
        foreach($tasks as $task) {
            $task->details = \Illuminate\Support\Str::words($task->details, 10, '...');
            $task->type = ucfirst($task->type);
            $task->due = now() > new DateTime($task->datetime);
            $task->datetime = \Carbon\Carbon::parse($task->datetime)->shortRelativeToNowDiffForHumans(); // TODO dont change datetime, put in new key
            $task->subject = $task->subject()->first();
        }

        $materials = auth()->user()->recentMaterials();
        foreach($materials as $material)
        {
            $material->name = \Illuminate\Support\Str::limit($material->name, 26);
            $material->categories = auth()->user()->categories()->whereIn('id', explode(",", $material->categories))->take(3)->get();
            $material->details = \Illuminate\Support\Str::words($material->details, 10, '...');
            $material->visited_at = \Carbon\Carbon::parse($material->visited_at)->shortRelativeToNowDiffForHumans();
            $material->subject = $material->subject()->first();
        }

        return response()->json([
            'schedule' => $schedule,
            'tasks' => $tasks,
            'materials' => $materials
        ]);
    }
}
