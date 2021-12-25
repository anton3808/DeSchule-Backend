<?php

namespace Modules\Study\Transformers\UserAnswers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Study\Entities\UserAnswers;

class UserAnswersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var UserAnswers|JsonResource $this */
        return [
            'lesson_id'         => $this->lesson_id,
            'lesson_element_id' => $this->lesson_element_id,
            'data'              => $this->data
        ];
    }
}
