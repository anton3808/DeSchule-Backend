<?php

namespace Modules\Study\Transformers\Lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Study\Entities\Lesson;

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
        /** @var Request|Lesson $this */
        return [
            'order' => $this->order,
            'level' => $this->level_id,
            'title' => $this->getTranslation(app()->getLocale())->title
        ];
    }
}
