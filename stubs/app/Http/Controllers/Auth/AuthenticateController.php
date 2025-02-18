<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateFormRequest;
use App\View\Pages\LoginPage;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthenticateController extends Controller
{
    public function form(LoginPage $page): LoginPage
    {
        return $page;
    }

    public function authenticate(AuthenticateFormRequest $request): RedirectResponse
    {
        if(!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => __('moonshine::auth.failed')
            ]);
        }

        return redirect()->intended(
            route('profile')
        );
    }

    public function logout(
        #[Auth]
        Guard $guard,
        Request $request
    ): RedirectResponse {
        $guard->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended(
            url()->previous() ? url()->previous() : route('home')
        );
    }
}
