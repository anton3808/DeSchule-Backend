<?php

namespace Modules\Study\Transformers\Lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Study\Entities\Lesson;
use Modules\Study\Transformers\LessonElement\LessonElementResource;
use Modules\Study\Transformers\Level\LevelResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var JsonResource|Lesson $this */
        return [
            'order'    => $this->order,
            'level'    => $this->whenLoaded('level', LevelResource::make($this->level), $this->level_id),
            'title'    => $this->title,
            'elements' => LessonElementResource::collection($this->whenLoaded('elements'))
        ];
    }
}
