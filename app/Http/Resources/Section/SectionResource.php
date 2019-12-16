<?php

namespace App\Http\Resources\Section;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\User;
use App\Http\Resources\User\UserResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'logo' => $this->logo,            
            'users' => UserResource::collection($this->users),
            'all_users' => UserResource::collection(User::all())            
        ];
    }
}
