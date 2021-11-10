<?php

namespace Modules\Study\Http\Requests\Level;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLevelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'priority' => 'required|numeric',
            'code'     => 'required|string|max:2',
            'title'    => 'required|array',
        ];
    }

    public function model(): array
    {
        return $this->except('title');
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
