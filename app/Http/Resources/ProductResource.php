<?php

namespace App\Http\Resources;

use App\Helpers\General;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'category_name' => $this->category_name,
            'price' => General::formatedNumberIDR($this->price),
            'selling_price' => General::formatedNumberIDR($this->selling_price),
            'stock' => $this->stock,
            'image' => Storage::url($this->image),
        ];
    }
}
