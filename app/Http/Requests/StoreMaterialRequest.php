<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMaterialRequest extends FormRequest
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
        $subjects = Subject::where('user_id', auth()->user()->id)->pluck('id')->toArray();
        $categories = Category::where('user_id', auth()->user()->id)->pluck('id')->toArray();

        return [
            'file' => 'required',
            'details' => 'string | nullable',
            'subject_id' => ['required', Rule::in($subjects)],
            'categories' => ['array', Rule::in($categories)],
        ];
    }
}
