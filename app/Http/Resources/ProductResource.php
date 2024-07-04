<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'price'=>[
                'normal'=>$this->price,
                'compare'=>$this->compare_price
            ],
            'relations'=>[
                'category'=>[
                   'id'=> $this->category->id,
                    'name'=> $this->category->name,
                ],

                'store'=>[
                    'id'=> $this->store->id,
                    'name'=> $this->store->name,
                ],
            ],
        ];
    }
}
