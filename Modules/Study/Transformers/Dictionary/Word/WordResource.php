<?php

namespace Modules\Study\Transformers\Dictionary\Word;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Study\Entities\Dictionary\Word;

class WordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Request|Word $this */
        return [
            'id'                           => $this->id,
            'word'                         => $this->word,
            'word_translation'             => $this->word_translation,
            'description'                  => $this->description,
            'word_description_translation' => $this->word_description_translation,
            'image'                        => $this->image
        ];
    }
}
