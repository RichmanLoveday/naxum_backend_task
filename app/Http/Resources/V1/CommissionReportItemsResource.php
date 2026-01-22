<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommissionReportItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sku' => $this->product->sku,
            'product_name' => $this->product->name,
            'price' => $this->product->price,
            'quantity' => $this->quantity,
            'total_price' => $this->product->price * $this->quantity,
        ];
    }
}
