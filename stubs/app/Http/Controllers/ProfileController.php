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
        $data = $request->only(['email', 'name']);

        if($request->filled('password')) {
            /** @var string $password */
            $password = $request->input('password');
            $data['password'] = Hash::make($password);
        }

        /** @var array<string, mixed> $updateData */
        $updateData = $data;
        $user->update($updateData);

        return to_route('profile');
    }

    public function updatePassword(
        UpdatePasswordRequest $request,
        #[CurrentUser] User $user
    ): RedirectResponse {
        /** @var array{password: string} $data */
        $data = $request->validated();

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return to_route('profile');
    }
}
