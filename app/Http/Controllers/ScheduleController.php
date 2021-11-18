<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleUpdateRequest;
use App\Http\Requests\StoreScheduleRequest;
use App\Models\Schedule;
use App\Models\Subject;
use App\Services\ScheduleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private $scheduleService;

    function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $schedules = $this->scheduleService->index();
        return View('schedule.index')->with('schedules', $schedules);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View('schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(StoreScheduleRequest $request)
    {
        $schedule = $this->scheduleService->store($request->validated());
        return redirect()->route('schedule.show', $schedule);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Schedule $schedule)
    {
        $this->scheduleService->authorize($schedule->id);
        return View('schedule.show')->with('schedule', $schedule);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Schedule $schedule)
    {
        $this->scheduleService->authorize($schedule->id);
        return View('schedule.edit')->with('schedule', $schedule);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Schedule $schedule
     * @return RedirectResponse
     */
    public function update(ScheduleUpdateRequest $request, Schedule $schedule)
    {
        $schedule = $this->scheduleService->update($schedule, $request->validated());
        $request->session()->flash('message', 'Success');
        return redirect()->route('schedule.show', $schedule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Schedule $schedule
     * @return string
     */
    public function destroy(Schedule $schedule)
    {
        $this->scheduleService->destroy($schedule->id);
        return redirect()->route('schedule.index');
    }

    public function toggleActive(Schedule $schedule)
    {
        $this->scheduleService->toggleActive($schedule);
        return redirect()->route('schedule.index');
    }
}
