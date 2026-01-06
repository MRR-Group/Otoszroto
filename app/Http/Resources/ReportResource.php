<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "reporter" => UserResource::make($this->whenLoaded("reporter")),
            "auction" => AuctionResource::make($this->whenLoaded("auction")),
            "reason" => $this->reason,
            "resolvedAt" => optional($this->resolved_at)?->toDateTimeString(),
            "createdAt" => optional($this->created_at)?->toDateTimeString(),
            "updatedAt" => optional($this->updated_at)?->toDateTimeString(),
        ];
    }
}
