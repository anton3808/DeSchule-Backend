<?php

namespace Modules\User\Transformers\Schedule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Entities\Schedule\ScheduleEvent;

class ScheduleEventResource extends JsonResource
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
            'event_type'    => $this->whenLoaded('eventType', ScheduleEventTypeResource::make($this->eventType), $this->event_type_id),
            'title'         => $this->title,
            'description'   => $this->description,
            'link'          => $this->when(!!$this->link_resource, $this->link_resource),
            'date'          => $this->date->format('d.m.Y H:i:s')
        ];
    }
}
