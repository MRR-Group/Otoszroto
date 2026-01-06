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
            "photo" => $this->photo,
            "price" => $this->price,
            "city" => $this->city,
            "owner" => UserResource::make($this->owner)->resolve(),
            "model" => ModelResource::make($this->model)->resolve(),
            "category" => CategoryResource::make($this->category)->resolve(),
            "condition" => $this->condition,
            "auctionState" => $this->auction_state,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "wasReported" => auth()->check()
                ? $this->reports->contains("reporter_id", auth()->id())
                : false,
        ];
    }
}
