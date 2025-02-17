<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordFormRequest;
use App\Http\Requests\Auth\ResetPasswordFormRequest;
use App\Models\User;
use App\View\Pages\ForgotPage;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use MoonShine\Laravel\MoonShineUI;

class ForgotController extends Controller
{
    public function form(ForgotPage $page): ForgotPage
    {
        return $page;
    }

    public function reset(ForgotPasswordFormRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            MoonShineUI::toast(__('If the account exists, then the instructions are sent to your email'));
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['alert' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function updatePassword(ResetPasswordFormRequest $request): RedirectResponse
    {
        /** @var string $status */
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            static function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('alert', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}