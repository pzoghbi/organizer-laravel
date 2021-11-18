<?php


namespace App\Services;


use App\Models\Subject;

class SubjectService
{
    public function store($data)
    {
        $subject = new Subject();
        $subject->name = $data['name'];
        $subject->user_id = auth()->id();
        $subject->save();
    }

    public function update($subject, $data)
    {
        $this->authorize($subject->id);
        $subject->name = $data['name'];
        $subject->color = $data['color'];
        $subject->save();
    }

    public function destroy($subject)
    {
        $this->authorize($subject->id);
        Subject::destroy($subject->id);
    }

    public function authorize($subject_id, $message = null)
    {
        $subjects = Subject::where('user_id', auth()->id())->pluck('id')->toArray();
        abort_unless(in_array($subject_id, $subjects), 403, $message);
    }
}
