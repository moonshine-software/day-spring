<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\ProfileFormRequest;
use App\Models\User;
use App\View\Pages\ProfilePage;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProfileController extends Controller
{
    public function index(
        ProfilePage $page
    ): ProfilePage {
        return $page;
    }

    public function update(
        ProfileFormRequest $request,
        #[CurrentUser] User $user
    ): RedirectResponse {
        $data = $request->validated();
        $user->update($data);
        return to_route('profile');
    }

    public function updatePassword(
        UpdatePasswordRequest $request,
        #[CurrentUser] User $user
    ): RedirectResponse {
        /** @var array<string, mixed> $data */
        $data = $request->only(['password']);
        $user->update($data);
        return to_route('profile');
    }
}
