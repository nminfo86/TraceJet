<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            UserResource::collection($this->collection)
            // 'user_id' => $this->id,
            // 'name'      => $this->name,
            // 'email'     => $this->email,
            // 'roles'     => $this->roles->name ?? [],
            // 'roles.permissions' => $this->getPermissionsViaRoles()->pluck(['name']) ?? [],
            // 'permissions' => $this->permissions->pluck('name') ?? []

        ];
    }
}