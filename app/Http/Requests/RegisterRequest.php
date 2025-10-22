<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $passwordRules = [
            'required', 
            'string', 
            'confirmed',
        ];

        $additionalRules = Password::min(config('auth.password_validation.min_length', 8));

        if (config('auth.password_validation.require_mixed_case', true)) {
            $additionalRules = $additionalRules->mixedCase(true);
        }

        if (config('auth.password_validation.require_numbers', true)) {
            $additionalRules = $additionalRules->numbers(true);
        }

        if (config('auth.password_validation.require_symbols', false)) {
            $additionalRules = $additionalRules->symbols(false);
        }

        $passwordRules[] = $additionalRules;

        return [
            'name' => 'required|string|max:' . config('database.user_model.name_max_length', 255),
            'email' => 'required|email|unique:' . config('database.user_model.table', 'users') . ',email',
            'password' => $passwordRules,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('messages.validation.name_required'),
            'email.required' => __('messages.validation.email_required'),
            'email.email' => __('messages.validation.email_invalid'),
            'email.unique' => __('messages.validation.email_unique'),
            'password.required' => __('messages.validation.password_required'),
            'password.confirmed' => __('messages.validation.password_confirmed'),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('validation.attributes.name'),
            'email' => __('validation.attributes.email'),
            'password' => __('validation.attributes.password'),
        ];
    }
}
