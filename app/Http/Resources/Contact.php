<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Contact extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'contact_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birthday' => $this->birthday->format('m/d/Y'),
            'company' => $this->company,
            'last_updated' => $this->updated_at->diffForHumans(),
        ];
    }
}
