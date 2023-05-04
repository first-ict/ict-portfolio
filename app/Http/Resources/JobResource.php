<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'name' =>$this->name,
            'post' =>$this->post,
            'description' =>$this->description,
            'requirement' =>$this->requirement,
            'contact' =>$this->contact,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at

        ];
    }
}
