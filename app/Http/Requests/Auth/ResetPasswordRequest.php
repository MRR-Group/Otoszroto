<?php

declare(strict_types=1);

namespace Otoszroto\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            "token" => ["required", "string"],
            "email" => ["required", "string", "email"],
            "password" => ["required", "string", "min:8", "max:255", "confirmed"],
        ];
    }
}
