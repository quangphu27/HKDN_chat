<?php

namespace App\Http\Requests\User;

use App\Rules\NotSameAsOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'password' => 'required|string|min:6', // Mật khẩu hiện tại
            'newpassword' => ['required', 'string', 'min:6', new NotSameAsOldPassword()],
            'renewpassword' => 'required|same:newpassword',
        ];
    }
}
