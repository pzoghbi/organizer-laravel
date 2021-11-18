<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Models\Lecture;
use App\Models\Schedule;
use App\Models\Subject;
use App\Services\LectureService;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    private $lectureService;

    public function __construct(LectureService $lectureService)
    {
        $this->lectureService = $lectureService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $schedule_id
     * @return string
     */
    public function store(StoreLectureRequest $request, $schedule_id)
    {
        $this->lectureService->store($schedule_id, $request->validated());
        return redirect()->route('schedule.edit', $schedule_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Lecture $lecture
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Lecture $lecture)
    {
        // Authorization
        $this->lectureService->authorize($lecture->schedule->id);
        return View('lecture.edit')->with('lecture', $lecture);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lecture $lecture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateLectureRequest $request, Lecture $lecture)
    {
        $lecture = $this->lectureService->update($lecture, $request->validated());
        return redirect()->route('schedule.edit', $lecture->schedule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Lecture $lecture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Lecture $lecture)
    {
        $this->lectureService->destroy($lecture->id);
        return redirect()->route('schedule.edit', $lecture->schedule);
    }
}
