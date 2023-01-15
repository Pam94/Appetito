<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
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
            'name' => $this->name,
            'time' => $this->time,
            'portions' => $this->portions,
            'instructions' => $this->instructions,
            'favorite' => $this->favorite,
            'url' => $this->url,
            'image_name' => $this->image_name,
            'ingredients' => $this->ingredients,
            'categories' => $this->categories
        ];
    }
}
