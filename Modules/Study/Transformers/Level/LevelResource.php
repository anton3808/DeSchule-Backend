<?php

namespace Modules\Study\Transformers\Level;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Study\Entities\Level;
use Request;

class LevelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Request|Level $this */
        return [
            'priority' => $this->priority,
            'code'     => $this->code,
            'title'    => $this->getTranslation(app()->getLocale())->title
        ];
    }
}
