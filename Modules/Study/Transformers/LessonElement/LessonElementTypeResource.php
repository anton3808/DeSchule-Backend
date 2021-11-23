<?php

namespace Modules\Study\Transformers\LessonElement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Study\Entities\LessonElementType;

class LessonElementTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var JsonResource|LessonElementType $this */
        return [
            'slug'        => $this->slug,
            'title'       => $this->title,
            'description' => $this->description,
        ];
    }
}
