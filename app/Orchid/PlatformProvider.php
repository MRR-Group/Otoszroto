<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return array<Menu>
     */
    public function menu(): array
    {
        return [
            Menu::make(__("Statystyki użytkowników"))
                ->icon("bs.house")
                ->route("platform.statistics.users")
                ->permission("platform.statistics.users")
                ->title(__("Statystyki")),

            Menu::make(__("Statystyki aukcji"))
                ->icon("bs.shield")
                ->route("platform.statistics.auctions")
                ->permission("platform.statistics.auctions")
                ->divider(),

            Menu::make("Zgłoszone aukcje")
                ->icon("bs.flag")
                ->title("Zgłoszenia")
                ->permission("platform.reports")
                ->route("platform.reports")
                ->divider(),

            Menu::make("Zarządzanie użytkownikami")
                ->icon("bs.people")
                ->route("platform.systems.users")
                ->permission("platform.systems.users")
                ->title("Zarządzanie"),

            Menu::make("Zarządzane rolami")
                ->icon("bs.shield")
                ->route("platform.systems.roles")
                ->permission("platform.systems.roles")
                ->divider(),

            Menu::make("Documentation")
                ->title("Docs")
                ->icon("bs.box-arrow-up-right")
                ->url("https://orchid.software/en/docs")
                ->target("_blank"),

            Menu::make("Changelog")
                ->icon("bs.box-arrow-up-right")
                ->url("https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md")
                ->target("_blank")
                ->badge(fn() => Dashboard::version(), Color::DARK),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return array<ItemPermission>
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__("System"))
                ->addPermission("platform.systems.roles", "Zarządzanie rolami")
                ->addPermission("platform.systems.users", "Zarządzanie użytkownikami"),

            ItemPermission::group("Statystyki")
                ->addPermission("platform.statistics.users", "Przeglądanie statystyk użytkowników")
                ->addPermission("platform.statistics.auctions", "Przeglądanie statystyk aukcji"),

            ItemPermission::group("Reports")
                ->addPermission("platform.reports", "Rozpatrywanie reportów"),
        ];
    }
}
