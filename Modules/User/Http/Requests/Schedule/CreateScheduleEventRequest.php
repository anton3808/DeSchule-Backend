<?php

namespace Modules\User\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class CreateScheduleEventRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user('sanctum')->id,
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
            'event_type_id' => 'required|numeric|exists:schedule_event_types,id',
            'user_id'       => 'required|numeric|exists:users,id',
            'title'         => 'required|string',
            'description'   => 'nullable|string',
            'date'          => 'required|date|after:now'
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

    public function eventTypeId()
    {
        return $this->get('event_type_id');
    }
}
