<?php


namespace App\Services;


use App\Models\Schedule;

class ScheduleService
{
    public function index()
    {
        $schedule = Schedule::where('user_id', auth()->id())->where('end', '>', today())->get();
        return $schedule;
    }

    public function store($data)
    {
        $schedule = new Schedule();
        $schedule->user_id = auth()->id();
        $schedule->name = $data['name'];
        $schedule->start = $data['start'];
        $schedule->end = $data['end'];
        $schedule->save();
        return $schedule;
    }

    public function update($schedule, $data)
    {
        $this->authorize($schedule->id);

        $schedule->start = $data['start'];
        $schedule->end = $data['end'];
        $schedule->save();

        return $schedule;
    }

    public function destroy($schedule_id)
    {
        $this->authorize($schedule_id);
        Schedule::destroy($schedule_id);
    }

    public function toggleActive($schedule)
    {
        $this->authorize($schedule->id);

        $schedules = Schedule::where('user_id', auth()->id());

        if (!$schedule->is_active) {
            $schedules->update(['is_active' => false]);
        }

        $schedule->is_active = !$schedule->is_active;
        $schedule->save();
    }

    public function authorize($schedule_id, $message = null)
    {
        $schedules = Schedule::where('user_id', auth()->id())->pluck('id')->toArray();
        abort_unless(in_array($schedule_id, $schedules), 403, $message);
    }
}
