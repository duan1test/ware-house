<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckinResource extends JsonResource
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
            'contact_id'        => $this->contact_id,
            'draft'             => $this->draft,
            'details'           => $this->details,
            'user_id'           => $this->user_id,
            'account_id'        => $this->account_id,
            'reference'         => $this->reference,
            'warehouse_id'      => $this->warehouse_id,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'deleted_at'        => $this->deleted_at,
            'user'         => $this->whenLoaded('user'),
            'items'        => $this->whenLoaded('items'),
            'contact'      => $this->whenLoaded('contact'),
            'warehouse'    => $this->whenLoaded('warehouse'),
            'attachments'  => $this->whenLoaded('attachments'),
        ];
    }
}
