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
            'id' => $this->id,
            'article' => $this->article,
            'name' => $this->name,
            'status' => $this->status,
            'data' => $this->data,
            'created_at' => date('Y-m-d H:i', strtotime($this->created_at)),
            'updated_at' => date('Y-m-d H:i', strtotime($this->updated_at)),
        ];
    }
}
