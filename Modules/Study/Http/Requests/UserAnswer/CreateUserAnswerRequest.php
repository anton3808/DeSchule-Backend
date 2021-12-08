<?php

namespace Modules\Study\Http\Requests\UserAnswer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Study\Rules\UserAnswer\UserAnswerDataRule;

class CreateUserAnswerRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->get('user_id', request()->user('sanctum')->id),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id'           => 'required|numeric|exists:users,id',
            'lesson_id'         => 'required|numeric|exists:lessons,id',
            'lesson_element_id' => 'required|numeric|exists:lesson_elements,id',
            'data'              => ['required', new UserAnswerDataRule($this->get('lesson_element_id'))],
            'data.*'            => [function ($attribute, $value, $fail) {
                if (is_null($value)) {
                    $fail(__('validation.custom.data.required'));
                }
            }]
        ];
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
