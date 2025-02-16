<?php

declare(strict_types=1);

namespace App\View\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\UI\Components\{Components,
    Layout\Body,
    Layout\Content,
    Layout\Div,
    Layout\Flash,
    Layout\Html,
    Layout\Layout,
    Layout\Wrapper};

final class ProfileLayout extends AppLayout
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
                    Wrapper::make([
                        Div::make([
                            Flash::make(),

                            Content::make([
                                Components::make(
                                    $this->getPage()->getComponents()
                                ),
                            ]),
                        ])->class('layout-page'),
                    ]),
                ])->class('theme-minimalistic'),
            ])
                ->customAttributes([
                    'lang' => $this->getHeadLang(),
                ])
                ->withAlpineJs()
                ->withThemes(),
        ]);
    }
}
