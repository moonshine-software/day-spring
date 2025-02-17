<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AuthenticateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

    /**
     * @return array<array-key, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required'],
            'password' => ['required', Password::default()],
        ];
    }
}