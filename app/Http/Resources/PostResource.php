<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id' => (string)$this->id,
            'type' => 'Posts',
            'attributes' => [
                'title' => $this->title,
                'image' => $this->image,
                'category' => new CategoryResource($this->category),
                'description' => $this->description,
                'views' => $this->views,
                'date' => $this->date,
            ]
        ];
    }
}
