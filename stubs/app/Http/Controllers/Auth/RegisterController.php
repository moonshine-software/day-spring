<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterFormRequest;
use App\Models\User;
use App\View\Pages\RegisterPage;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function form(RegisterPage $page): RegisterPage
    {
        return $page;
    }

    public function store(RegisterFormRequest $request): RedirectResponse
    {
        $user = User::query()->create(
            $request->validated()
        );

        auth()->login($user);

        return redirect()->intended(
            route('home')
        );
    }
}
