<?php

declare(strict_types=1);

namespace App\View\Pages;

use MoonShine\Contracts\UI\ComponentContract;
use stdClass;
use Jenssegers\Agent\Agent;
use MoonShine\UI\Fields\Preview;
use MoonShine\Laravel\Pages\Page;
use MoonShine\UI\Components\Icon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use MoonShine\UI\Components\Badge;
use MoonShine\UI\Components\Title;
use App\View\Layouts\ProfileLayout;
use Illuminate\Support\Facades\Auth;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\CardsBuilder;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;

/**
 * @template-extends Page<null>
 */
class SessionPage extends Page
{
    protected ?string $layout = ProfileLayout::class;

    protected ?Agent $agent = null;

    public function getTitle(): string
    {
        return $this->title ?: 'Sessions';
    }

    public function setAgent(Agent $agent): self
    {
        $this->agent = $agent;
        return $this;
    }

    public function components(): iterable
    {
        if(is_null($this->agent)){
            return [];
        }

        $this->clearUserSessions();

        /** @var Collection<array-key, object{
         *     user_agent: string,
         *     ip_address: string,
         *     last_activity: int,
         *     last_activity_date: string,
         *     isDesktop: bool,
         *     os: string,
         *     browser: string
         * }&stdClass> $sessions
         */
        $sessions = DB::table('sessions')
            ->select(['ip_address', 'user_agent', 'last_activity'])
            ->where('user_id', Auth::id())
            ->orderBy('last_activity', 'desc')
            ->get();

        /** @var Agent $agent */
        $agent = $this->agent;

        $sessions = $sessions->map(static function ($session) use ($agent) {
            $agent->setUserAgent($session->user_agent);
            $session->os = $agent->platform() ? $agent->platform() : '';
            $session->browser = $agent->browser() ? $agent->browser() : '';
            $session->isDesktop = $agent->isDesktop();
            $session->last_activity_date = date('d.m.Y H:i', $session->last_activity);
            return $session;
        });

        $cards = CardsBuilder::make()
            ->items($sessions)
            ->columnSpan(2, 2)
            ->customComponent(function (mixed $item, int $index, CardsBuilder $builder): ComponentContract {
                /** @var object{
                 *     user_agent: string,
                 *     ip_address: string,
                 *     last_activity_date: string,
                 *     isDesktop: bool,
                 *     os: string,
                 *     browser: string
                 * } $item
                 */
                $infoComponent = $item->user_agent === request()->header('User-Agent')
                    ? Preview::make()->setValue($item->ip_address . ' ' . Badge::make(__('This device'), 'green'))
                    : Preview::make()->setValue($item->ip_address);

                return Box::make([Grid::make([
                    Column::make([
                        Icon::make($item->isDesktop ? 'tv' : 'device-phone-mobile', 10),
                    ])->columnSpan(2),
                    Column::make([
                        Preview::make()->setValue($item->os . ' - ' . $item->browser),
                        Preview::make()->setValue($item->last_activity_date),
                        $infoComponent
                    ])
                        ->columnSpan(10),
                ])
                ]);
            })
        ;

        return [
            Title::make(__('Sessions')),
            Divider::make(),
            $cards
        ];
    }

    private function clearUserSessions(): void
    {
        /** @var int $sessionLifetime */
        $sessionLifetime = config('session.lifetime');
        $sessionLifetime = $sessionLifetime * 60;

        DB::table('sessions')
            ->where('user_id', Auth::id())
            ->where('last_activity', '<', time() - $sessionLifetime)
            ->delete();
    }
}