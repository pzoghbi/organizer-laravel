<?php


namespace App\Services;


use App\Models\Lecture;
use App\Models\Schedule;

class LectureService
{
    public function store($schedule_id, $data)
    {
        $this->authorize($schedule_id);

        $lecture = new Lecture();
        $lecture->schedule_id = $schedule_id;
        $lecture->subject_id = $data['subject_id'];
        $lecture->day = $data['day'];
        $lecture->start = $data['start'];
        $lecture->end = $data['end'];
        $lecture->room = $data['room'];

        $lecture->save();
    }

    public function update($lecture, $data)
    {
        $this->authorize($lecture->schedule->id);

        $lecture->subject_id = $data['subject_id'];
        $lecture->day = $data['day'];
        $lecture->start = $data['start'];
        $lecture->end = $data['end'];
        $lecture->room = $data['room'];
        $lecture->save();

        return $lecture;
    }

    /**
     * Returns the number of destroyed items
     *
     * @return int
     * */
    public function destroy($lecture_id){
        $lecture = Lecture::where('id', $lecture_id)->first();
        $this->authorize($lecture->schedule_id);
        return Lecture::destroy($lecture_id);
    }

    public function authorize($schedule_id)
    {
        $schedules = Schedule::where('user_id', auth()->id())->pluck('id')->toArray();
        abort_unless(
            in_array($schedule_id, $schedules),
            403,
            'You don\'t have the rights to this resource.'
        );
    }
}
