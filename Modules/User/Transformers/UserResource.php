<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Request|User $this */
        return [
            'name'     => $this->name,
            'surname'  => $this->surname,
            'email'    => $this->email,
            'phone'    => $this->phone,
            'birthday' => $this->birthday,
        ];
    }
}
