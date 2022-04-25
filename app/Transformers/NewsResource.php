<?php

namespace App\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\News\News;

class NewsResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var JsonResource|News $this */
        return [
            'id'    => $this->id,
            'image' => $this->image,
            'title'    => $this->title,
            'description'    => $this->description,
            'comments'    => $this->comments
        ];
    }
}
