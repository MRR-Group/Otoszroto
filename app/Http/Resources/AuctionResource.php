<?php

declare(strict_types=1);

namespace Otoszroto\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "photo_url" => $this->photo_url,
            "price" => $this->price,
            "owner_id" => $this->owner_id,
            "model_id" => $this->model_id,
            "category_id" => $this->category_id,
            "condition_id" => $this->condition_id,
            "auction_state" => $this->auction_state,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
