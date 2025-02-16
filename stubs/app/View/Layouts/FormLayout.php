<?php

declare(strict_types=1);

namespace App\View\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\UI\Components\{Components,
    Layout\Body,
    Layout\Div,
    Layout\Flash,
    Layout\Html,
    Layout\Layout};

final class FormLayout extends AppLayout
{
    protected function getHomeUrl(): string
    {
        return route('home');
    }

    public function build(): Layout
    {
        return Layout::make([
            Html::make([
                $this->getHeadComponent(),
                Body::make([
                    Div::make([
                        Div::make([
                            $this->getLogoComponent(),
                        ])->class('authentication-logo'),

                        Div::make([
                            Flash::make(),
                            Components::make($this->getPage()->getComponents()),
                        ])->class('authentication-content'),
                    ])->class('authentication'),
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
