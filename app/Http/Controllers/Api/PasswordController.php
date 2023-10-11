<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class PasswordController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request = $request->validated();
        $user = Auth::user();
        if (strcmp($request->current_password, $request->new_password) == 0) {
//                throw new NewPasswordCannotBeSameAsOld("New password cannot be same as the old one.");
            return response(['message' => 'New password cannot be same as the old.'], 400);
        }

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => bcrypt($request->new_password)
            ]);
            return response([
                'message' => 'Password updated successfully'
            ], 200);
        }

        return response([
            'message' => 'Password could not be updated'
        ], 409);

//            } else {
//        if ($this->userRepository->updatePassword($updatePasswordRequest)) {
//            $user = auth()->user();
//            if (strcmp($updatePasswordRequest->old_password, $updatePasswordRequest->new_password) == 0) {
//                throw new NewPasswordCannotBeSameAsOld("New password cannot be same as the old one.");
//            }
//            if (Hash::check($updatePasswordRequest->old_password, $user->password)) {
//                $user->update([
//                    'password' => bcrypt($updatePasswordRequest->new_password)
//                ]);
//                return true;
//            } else {
//                return false;
//            }
//            return $this->respondWithCustomData(['message' => 'Password updated successfully!']);
//        }
//        return $this->respondWithCustomData(['message' => 'Password could not be updated.']);
    }

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
