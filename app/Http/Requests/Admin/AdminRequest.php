<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(Admin::class),
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Admin::class),
            ],
            'phone_number' => [
                'required',
                'string',
                'max:11',
                Rule::unique(Admin::class),
            ],

            'password' => [
                'required',
                'string',
                Password::default(),
            ],
            'roles'=> [
                'required',
                'array'
            ],
        ];
    }
}
