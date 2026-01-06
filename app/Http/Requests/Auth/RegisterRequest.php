<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "firstname" => ["required", "string", "max:255"],
            "surname" => ["required", "string", "max:255"],
            "phone" => ["required", "string", "max:16", "unique:users"],
            "email" => ["required", "string", "email:rfc,dns", "max:255", "unique:users"],
            "password" => ["required", "string", "min:8", "max:255", "confirmed"],
        ];
    }
}
