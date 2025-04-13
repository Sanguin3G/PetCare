<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product' => $this->items(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(), // total pages
            'total' => $this->total(), // // total product
            'per_page' => $this->perPage(),

        ];
    }
}
