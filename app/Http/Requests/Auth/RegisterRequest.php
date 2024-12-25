<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'role' => ['in:normal_user,moderate_user,admin'], // loại bỏ default tại đây
            'confirmPassword' => ['required', 'same:password'],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'name.min' => 'Vui lòng nhập nhiều hơn 5 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được đăng ký.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role.in' => 'Quyền không hợp lệ.',
            'confirmPassword.required' => 'Vui lòng xác nhận mật khẩu.',
            'confirmPassword.same' => 'Mật khẩu xác nhận không khớp.',
        ];
    }
}
