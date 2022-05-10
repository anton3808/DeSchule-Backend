<?php

namespace App\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ScheduleEventTypeResource;

class ScheduleEventResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var ScheduleEvent|JsonResource $this */
        return [
            'id'          => $this->id,
            'event_type'  => $this->whenLoaded('eventType', ScheduleEventTypeResource::make($this->eventType), $this->event_type_id),
            'title'       => $this->title,
            'description' => $this->description,
            'link'        => $this->when(!!$this->link_resource, $this->link_resource),
            'date'        => $this->date->format('d.m.Y H:i:s')
        ];
    }
}
