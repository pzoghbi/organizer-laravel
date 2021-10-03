<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $schedules = Schedule::where('user_id', auth()->user()->id)
            ->where('end', '>', today())->get();

        return View('schedule.index')->with('schedules', $schedules);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $subjects = Subject::where('user_id', auth()->user()->id)->get();

        return View('schedule.create')
            ->with('subjects', $subjects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start' => 'required|before:end',
            'end' => 'required|after:start'
        ]);

        $schedule = new Schedule();
        $schedule->user_id = auth()->user()->id;
        $schedule->name = $request->input('name');
        $schedule->start = $request->input('start');
        $schedule->end = $request->input('end');
        $schedule->save();

        return redirect()->route('schedule.show', $schedule);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Schedule $schedule)
    {
        $subjects = Subject::where('user_id', auth()->user()->id)->pluck('name', 'id')->toArray();
        $schedule->lectures = $schedule->lectures->sortBy('start')->groupBy('day');

        return View('schedule.show')
            ->with('schedule', $schedule)
            ->with('subjects', $subjects);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Schedule $schedule)
    {
        $subjects = Subject::where('user_id', auth()->user()->id)->pluck('name', 'id')->toArray();
        $schedule->lectures = $schedule->lectures->sortBy('start')->groupBy('day')->all();

        return View('schedule.edit')
            ->with('schedule', $schedule)
            ->with('subjects', $subjects);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
