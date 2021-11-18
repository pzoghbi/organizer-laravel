<?php

namespace App\Http\Requests;

use App\Models\Subject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $my_subjects = Subject::where('user_id', auth()->user()->id)->pluck('id')->all();
        $task_types = ['assignment', 'exam', 'reminder'];

        return [
            'title' => 'required | max:256',
            'details' => 'nullable | max:1024',
            'type' => [Rule::in($task_types)            ],
            'subject_id' => ['required', Rule::in($my_subjects)],
            'datetime' => 'required | after_or_equal:today'
        ];
    }
}
