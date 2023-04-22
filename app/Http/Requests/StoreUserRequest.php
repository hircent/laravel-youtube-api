<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // set to true if user is authorize to register
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // make sure form has name="password_confirmation" for conforming password
        return [
            'name'=>['required','string','max:255','unique:users'],
            'email'=>['required','string','max:255','unique:users'],
            'password'=>['required','confirmed',Password::defaults()]
        ];
    }
}
