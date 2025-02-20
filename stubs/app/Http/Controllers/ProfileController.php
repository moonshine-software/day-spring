<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\ProfileFormRequest;
use App\Models\User;
use App\View\Pages\ProfilePage;
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
    ): RedirectResponse {
        $data = $request->validated();
        /** @var User $user */
        $user = $request->user();
        $user->update($data);
        return to_route('profile');
    }

    public function updatePassword(
        UpdatePasswordRequest $request,
    ): RedirectResponse {
        /** @var array{password: string} $data */
        $data = $request->validated();
        /** @var User $user */
        $user = $request->user();
        $user->update([
            'password' => Hash::make($data['password']),
        ]);
        return to_route('profile');
    }
}
