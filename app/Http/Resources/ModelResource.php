<?php

declare(strict_types=1);

namespace Otoszroto\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "brand" => BrandResource::make($this->brand)->resolve()
        ];
    }
}
