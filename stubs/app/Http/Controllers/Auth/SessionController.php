<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\View\Pages\SessionPage;
use Jenssegers\Agent\Agent;

class SessionController extends Controller
{
    public function sessions(SessionPage $page, Agent $agent): SessionPage
    {
        $page->setAgent($agent);

        return $page;
    }
}