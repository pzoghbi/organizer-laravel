<?php

namespace App\Http\Requests;

use App\Models\Subject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateMaterialRequest extends FormRequest
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
        $this_user_subjects = Subject::where('user_id', auth()->user()->id)->pluck('id')->toArray();

        dd($this_user_subjects);

        return [
            'path' => 'required',
            'name' => 'required',
            'details' => 'required',
            'user_id' => 'required',
            'subject_id' => [
                'required',
                Rule::in($this_user_subjects)
            ],
            'categories'
        ];
    }
}
