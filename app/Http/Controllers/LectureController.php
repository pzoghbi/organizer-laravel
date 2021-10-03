<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $schedule_id
     * @return string
     */
    public function store(Request $request, $schedule_id)
    {
        // TODO validation and validate for overlapping classes
        $lecture = new Lecture();
        $lecture->schedule_id = $schedule_id;
        $lecture->subject_id = $request->input('subject_id');
        $lecture->day = $request->input('day');
        $lecture->start = $request->input('start');
        $lecture->end = $request->input('end');
        $lecture->room = $request->input('room');
        $lecture->save();

        return redirect()->route('schedule.edit', $schedule_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function show(Lecture $lecture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lecture  $lecture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Lecture $lecture)
    {
        $schedule = Schedule::findOrFail($lecture->schedule_id);
        $schedule->lectures = $schedule->lectures->sortBy('start')->groupBy('day')->all();
        $subjects = Subject::where('user_id', auth()->user()->id)->pluck('name', 'id')->toArray();

        return View('lecture.edit')
            ->with('schedule', $schedule)
            ->with('lecture', $lecture)
            ->with('subjects', $subjects);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lecture  $lecture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Lecture $lecture)
    {
        // TODO validation and validate for overlapping classes

        $lecture->subject_id = $request->input('subject_id');
        $lecture->day = $request->input('day');
        $lecture->start = $request->input('start');
        $lecture->end = $request->input('end');
        $lecture->room = $request->input('room');
        $lecture->save();

        return redirect()->route('schedule.edit', $lecture->schedule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lecture  $lecture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Lecture $lecture)
    {
        Lecture::destroy($lecture->id);

        return redirect()->route('schedule.edit', $lecture->schedule);
    }
}
