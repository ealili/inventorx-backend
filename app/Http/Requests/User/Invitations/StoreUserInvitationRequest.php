<?php

namespace App\Http\Requests\User\Invitations;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:user_invitations,email',
            'role_id' => 'required|int|exists:roles,id',
            'team_id' => 'required|exists:teams,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.unique' => 'A user with this email has already been invited',
        ];
    }
}
