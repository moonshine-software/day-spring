<?php

declare(strict_types=1);

namespace App\View\Layouts;

use MoonShine\Contracts\MenuManager\MenuElementContract;
use MoonShine\Laravel\Components\Layout\Profile;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\UI\Components\{Components,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Div,
    Layout\Flash,
    Layout\Html,
    Layout\Layout,
    Layout\Menu,
    Layout\MobileBar,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\TopBar,
    Layout\Wrapper};
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
        $menu = [
            MenuItem::make(__('Profile'), route('profile'))->icon('user')
        ];

        if(config('moonshine-spring.features.sessions')) {
            $menu[] = MenuItem::make(__('Sessions'), route('sessions'));
        }

        return $menu;
    }

    /**
     * @return list<MenuElementContract>
     */
    protected function topMenu(): array
    {
        return [
            MenuItem::make('Welcome', route('home'))
        ];
    }

    protected function getSidebarComponent(): Sidebar
    {
        return Sidebar::make([
            Div::make([
                Div::make([
                    $this->getLogoComponent()->minimized(),
                ])->class('menu-heading-logo'),

                Div::make([
                    ThemeSwitcher::make(),

                    Div::make([
                        Burger::make(),
                    ])->class('menu-heading-burger'),
                ])->class('menu-heading-actions'),
            ])->class('menu-heading'),

            Div::make([
                Menu::make(),
                $this->getProfileComponent(sidebar: true),
            ])->customAttributes([
                'class' => 'menu',
                ':class' => "asideMenuOpen && '_is-opened'",
            ]),
        ])->collapsed();
    }

    protected function getTopBarComponent(): Topbar
    {
        return TopBar::make([
            Div::make([
                Menu::make($this->topMenu())->top(),
            ])->class('menu-navigation'),

            Div::make([
                Div::make([
                    Burger::make(),
                ])->class('menu-burger'),
            ])->class('menu-actions'),
        ])->customAttributes([
            ':class' => "asideMenuOpen && '_is-opened'",
        ]);
    }

    protected function getProfileComponent(bool $sidebar = false): Profile
    {
        return Profile::make(
            route: route('profile'),
            logOutRoute: route('logout'),
            avatar: static fn() => false,
            withBorder: $sidebar,
            guard: 'web'
        );
    }

    public function build(): Layout
    {
        return Layout::make([
            Html::make([
                $this->getHeadComponent(),
                Body::make([
                    Wrapper::make([
                        MobileBar::make([
                            Div::make([
                                Div::make([
                                    $this->getLogoComponent()->minimized(),
                                ])->class('menu-heading-logo'),

                                Div::make([
                                    ThemeSwitcher::make(),

                                    Div::make([
                                        Burger::make(),
                                    ])->class('menu-heading-burger'),
                                ])->class('menu-heading-actions'),
                            ])->class('menu-heading'),

                            Div::make([
                                Menu::make([
                                    ...$this->menu(),
                                    ...$this->topMenu(),
                                ]),
                                $this->getProfileComponent(),
                            ])->customAttributes([
                                'class' => 'menu',
                                ':class' => "asideMenuOpen && '_is-opened'",
                            ]),
                        ]),

                        $this->getTopBarComponent(),
                        $this->getSidebarComponent(),

                        Div::make([
                            Flash::make(),

                            Content::make([
                                Components::make(
                                    $this->getPage()->getComponents()
                                ),
                            ]),
                        ])->class('layout-page'),
                    ]),
                ]),
            ])
                ->customAttributes([
                    'lang' => $this->getHeadLang(),
                ])
                ->withAlpineJs()
                ->withThemes(),
        ]);
    }
}
