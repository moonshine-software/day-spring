<?php

declare(strict_types=1);

namespace App\View\Pages;

use App\View\Layouts\ProfileLayout;
use Illuminate\Session\SessionManager;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Pages\Page;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\LineBreak;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Text;

/**
 * @template-extends Page<null>
 */
class ProfilePage extends Page
{
    protected ?string $layout = ProfileLayout::class;

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle(),
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'LoginPage';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        $errors = session('errors');

        return [

            FormBuilder::make()
                ->class('authentication-form')
                ->action(route('profile.update'))
                ->fill(auth()->user())
                ->fields([
                    Text::make(__('Name'), 'name')->required(),
                    Text::make('E-mail', 'email')
                        ->required()
                        ->customAttributes([
                            'autofocus' => true,
                            'autocomplete' => 'off',
                        ]),
                ])
                ->name('profile')
                ->submit(__('Update profile'), [
                    'class' => 'btn-primary btn-lg',
                ]),

            Divider::make(),

            FormBuilder::make()
                ->class('authentication-form')
                ->action(route('profile.password.update'))
                ->fill(auth()->user())
                ->fields([
                    Password::make(__('Current password'), 'current_password'),
                    Password::make(__('Password'), 'password'),
                    PasswordRepeat::make(__('Repeat password'), 'password_confirmation'),
                ])
                ->name('updatePassword')
                ->submit(__('Update password'), [
                    'class' => 'btn-primary btn-lg',
                ]),

            Divider::make(),

            FormBuilder::make()
                ->name('logout')
                ->class('authentication-form')
                ->action(route('logout'))
                ->fields([
                    Hidden::make('_method')->setValue('DELETE'),
                ])->submit(__('Log out'), [
                    'class' => 'btn-error btn-lg',
                ]),
        ];
    }
}
