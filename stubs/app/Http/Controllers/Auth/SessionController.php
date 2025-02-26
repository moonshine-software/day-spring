<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\SessionsLogoutRequest;
use App\View\Pages\SessionPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use MoonShine\Laravel\Http\Controllers\MoonShineController;

class SessionController extends MoonShineController
{
    public function sessions(SessionPage $page, Agent $agent): SessionPage
    {
        $page->setAgent($agent);

        return $page;
    }

    public function logoutOther(SessionsLogoutRequest $request): RedirectResponse
    {
        /** @var string $connection */
        $connection = config('session.connection');

        DB::connection($connection)->table($connection)
            ->where('user_id', $request->user()?->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        $this->toast(__('The sessions are successfully reset'));

        return back();
    }
}