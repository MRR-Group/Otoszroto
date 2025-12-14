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
            "photo" => $this->photo_url,
            "price" => $this->price,
            "owner" => UserResource::make($this->owner),
            "model" => $this->model->name,
            "category" => $this->category->name,
            "condition" => $this->condition,
            "auctionState" => $this->auction_state,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
        ];
    }
}
