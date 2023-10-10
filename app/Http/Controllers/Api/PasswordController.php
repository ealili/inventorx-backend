<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class PasswordController extends Controller
{
    public function sendPasswordResetLink(ForgotPasswordRequest $forgotPasswordRequest)
    {
        if (!User::where('email', $forgotPasswordRequest->email)->first()) {
//            throw UserDoesNotExist::withEmail($forgotPasswordRequest->email);
            return response(['message' => 'Provided email is not associated to an account'], 404);

        }
        $response = Password::sendResetLink(
            $forgotPasswordRequest->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return response(['message' => 'Password reset link sent!'], 200);
        } else {
            return response(['message' => 'Password reset link could not be sent!'], 500);

        }
    }

    public function resetPassword(ResetPasswordRequest $resetPasswordRequest)
    {
        $status = Password::reset(
            $resetPasswordRequest->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response(['message' => 'Password reset successfully.'], 200);
        }
        return response(['message' => 'Password could not be reset.'], 500);

    }
}
