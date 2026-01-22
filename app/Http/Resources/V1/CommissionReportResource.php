<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommissionReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invoice' => $this->invoice_number,
            'purschaser' => $this->purchaser->first_name . ' ' . $this->purchaser->last_name,
            'distributor' => $this->purchaser->distributor ? $this->purchaser->distributor->first_name . ' ' . $this->purchaser->distributor->last_name : null,
            'reffered_distributors' => $this->reffered_distributors,
            'percentage' => $this->percentage,
            'commission' => number_format($this->commission_amount, 2),
            'order_total' => number_format($this->order_total, 2),
            'order_date' => $this->order_date,
        ];
    }
}
