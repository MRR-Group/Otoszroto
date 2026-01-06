<?php

declare(strict_types=1);

namespace App\Http\Requests\Auction;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        $auction = $this->route("auction");

        if ($user === null || $auction === null) {
            return false;
        }

        return $user->can("report", $auction);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "reason" => ["sometimes", "string", "max:255"],
        ];
    }
}
