<?php

namespace Modules\Study\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;

class CreateLessonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'order' => 'required|numeric|min:1',
            'title' => 'required|array',
            'level' => 'required|exists:levels,id'
        ];
    }

    public function model(): array
    {
        return array_merge($this->except(['title', 'level']), ['level_id' => $this->get('level')]);
    }

    public function translatable(): array
    {
        return $this->get('title');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
