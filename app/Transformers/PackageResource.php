<?php

namespace App\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Package\Package;

class PackageResource extends JsonResource
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
        /** @var JsonResource|Package $this */
        return [
            'id'    => $this->id,
            'image' => $this->image,
            'title'    => $this->title,
            'description'    => $this->description,
            'price'    => $this->price,
            'type'    => $this->type,

        ];
    }
}
