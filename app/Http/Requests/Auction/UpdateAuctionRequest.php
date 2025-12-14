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
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["sometimes", "required", "string", "min:3", "max:255"],
            "description" => ["sometimes", "string", "max:255"],
            "price" => ["sometimes", "required", "numeric", "min:0.01"],
            "model_id" => ["sometimes", "required", "integer", "exists:car_models,id"],
            "category_id" => ["sometimes", "required", "integer", "exists:categories,id"],
            "condition" => ["sometimes", "required", Rule::enum(Condition::class)],
            "auction_state" => ["sometimes", "required", Rule::enum(AuctionState::class)],
        ];
    }
}
