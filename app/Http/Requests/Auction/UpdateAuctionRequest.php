<?php

declare(strict_types=1);

namespace Otoszroto\Http\Requests\Auction;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Otoszroto\Enums\AuctionState;
use Otoszroto\Enums\Condition;

class UpdateAuctionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["sometimes", "string", "max:255"],
            "description" => ["sometimes", "string", "max:255"],
            "photo_url" => ["sometimes", "string", "max:255"],
            "price" => ["sometimes", "numeric"],
            "model_id" => ["sometimes", "integer", "exists:car_models,id"],
            "category_id" => ["sometimes", "integer", "exists:categories,id"],
            "condition" => ["sometimes", Rule::enum(Condition::class)],
            "auction_state" => ["sometimes", Rule::enum(AuctionState::class)],
        ];
    }
}
