<?php

declare(strict_types=1);

namespace App\View\Layouts;

use MoonShine\Contracts\MenuManager\MenuElementContract;
use MoonShine\Laravel\Components\Layout\Profile;
use MoonShine\Laravel\Layouts\AppLayout;

use MoonShine\MenuManager\MenuItem;

final class ProfileLayout extends AppLayout
{
    protected function onBoot(): void
    {
        parent::onBoot();

        $this->getCore()->getConfig()->homeRoute('home');
    }

    protected function getHomeUrl(): string
    {
        return route('home');
    }

    /**
     * @return list<MenuElementContract>
     */
    protected function menu(): array
    {
        return [
            MenuItem::make(route('profile'), __('Profile'))->icon('user')
        ];
    }

    protected function getProfileComponent(): Profile
    {
        return Profile::make(
            route: route('profile'),
            logOutRoute: route('logout'),
            avatar: static fn() => false,
            guard: 'web'
        );
    }
}
