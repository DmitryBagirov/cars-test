<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $email
 * @property string $password
 */
class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5',
        ];
    }
}
