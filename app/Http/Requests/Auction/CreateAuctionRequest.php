<?php

declare(strict_types=1);

namespace App\Http\Requests\Auction;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\Condition;

class CreateAuctionRequest extends FormRequest
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
            "name" => ["required", "string", "max:255"],
            "description" => ["required", "string", "max:255"],
            "city" => ["required", "string", "max:255"],
            "price" => ["required", "numeric"],
            "model_id" => ["required", "integer", "exists:car_models,id"],
            "category_id" => ["required", "integer", "exists:categories,id"],
            "condition" => ["required", Rule::enum(Condition::class)],
            "photo" => ["image", "mimes:png", "max:2048"],
        ];
    }
}
