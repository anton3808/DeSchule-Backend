<?php

namespace Modules\Study\Transformers\LessonElement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Study\Entities\LessonElement;

class LessonElementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var JsonResource|LessonElement $this */
        return [
            'icon'        => $this->icon,
            'title'       => $this->title,
            'description' => $this->description,
            'type'        => LessonElementTypeResource::make($this->whenLoaded('elementType')),
            'data'        => $this->data
        ];
    }
}
