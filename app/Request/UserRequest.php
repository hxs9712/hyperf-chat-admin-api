<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class UserRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'user_name'=>'required',
            'nick_name'=>'required',
            'password'=>'required',
        ];
    }

    public function messages(): array
    {
        return [
            'user_name.required' => '用户名必填',
            'password.required'  => '密码必填',
            'nick_name.required'  => '昵称必填',
        ];
    }
}
