<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'date'              => $this->date,
            'type'              => $this->type,
            'draft'             => $this->draft,
            'details'           => $this->details,
            'user_id'           => $this->user_id,
            'reference'         => $this->reference,
            'to_warehouse_id'   => $this->to_warehouse_id,
            'from_warehouse_id' => $this->from_warehouse_id,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'deleted_at'        => $this->deleted_at,
            'user'              => $this->whenLoaded('user'),
            'items'             => $this->whenLoaded('items'),
            'attachments'       => $this->whenLoaded('attachments'),
            'to_warehouse'      => $this->whenLoaded('toWarehouse'),
            'from_warehouse'    => $this->whenLoaded('fromWarehouse'),
        ];
    }
}
