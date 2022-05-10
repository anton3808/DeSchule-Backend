<?php

namespace App\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Schedule\ScheduleEventType;

class ScheduleEventTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var ScheduleEventType|JsonResource $this */
        return [
            'id'    => $this->id,
            'slug'  => $this->slug,
            'title' => $this->title
        ];
    }
}
