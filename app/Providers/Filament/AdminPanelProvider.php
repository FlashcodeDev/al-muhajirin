<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use App\Filament\Widgets\StatsOverview;
use Filament\Navigation\NavigationItem;
use App\Filament\Resources\UserResource;
use Filament\Navigation\NavigationGroup;
use App\Filament\Resources\GaleriResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use App\Filament\Resources\LayananResource;
use App\Filament\Resources\KegiatanResource;
use App\Filament\Resources\KeuanganResource;
use App\Filament\Resources\PengurusResource;
use App\Filament\Resources\JadwalJumatResource;
use App\Filament\Resources\PengelolaanResource;
use App\Filament\Resources\TentangKamiResource;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\Resources\LayananMasjidResource;
use App\Filament\Resources\KategoriKeuanganResource;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Widgets\KeuanganChart;
use App\Filament\Widgets\StatsKhotibOverview;
use Filament\Widgets\Widget;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->sidebarCollapsibleOnDesktop(true)
            ->id('admin')
            ->path('admin')
            ->login()
            ->databaseNotifications()
            // ->brandName('Al-Muhajirin')
            ->brandLogo(asset('images/Logo.png'))
            ->colors([
                'danger' => Color::Red,
                'gray' => Color::Zinc,
                'info' => Color::Blue,
                'primary' => Color::Amber,
                'success' => Color::Green,
                'warning' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                StatsKhotibOverview::class,
                StatsOverview::class,
                KeuanganChart::class
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make()
                        ->items([
                            NavigationItem::make('Dashboard')
                                ->icon('heroicon-o-home')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                                ->url(fn (): string => Dashboard::getUrl()),
                        ]),
                    NavigationGroup::make('Data Master')
                        ->icon('heroicon-o-folder-open')
                        ->items([
                            NavigationItem::make('Pengurus')
                                ->icon('heroicon-o-user-group')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.penguruses.index'))
                                ->url(fn (): string => PengurusResource::getUrl()),
                        ]),

                    NavigationGroup::make()
                        ->items([
                            NavigationItem::make('Jadwal Jumat')
                                ->icon('heroicon-o-sparkles')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.jadwal-jumats.index'))
                                ->url(fn (): string => JadwalJumatResource::getUrl()),
                        ]),
                    NavigationGroup::make()
                        ->items([
                            NavigationItem::make('Pengelolaan')
                                ->icon('heroicon-o-clipboard-document-list')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.pengelolaans.index'))
                                ->url(fn (): string => PengelolaanResource::getUrl()),
                        ]),
                    NavigationGroup::make('Kelola Keuangan')
                        ->icon('heroicon-o-currency-dollar')
                        ->items([
                            NavigationItem::make('Keuangan')
                                ->icon('heroicon-o-clipboard-document-list')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.keuangans.index'))
                                ->url(fn (): string => KeuanganResource::getUrl()),
                            NavigationItem::make('Kategori Keuangan')
                                ->icon('heroicon-o-clipboard-document-list')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.kategori-keuangans.index'))
                                ->url(fn (): string => KategoriKeuanganResource::getUrl()),
                            
                        ]),
                    NavigationGroup::make('Post')
                        ->icon('heroicon-o-viewfinder-circle')
                        ->items([
                            NavigationItem::make('Kegiatan')
                                ->icon('heroicon-o-puzzle-piece')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.kegiatans.index'))
                                ->url(fn (): string => KegiatanResource::getUrl()),
                            NavigationItem::make('Layanan Masjid')
                                ->icon('heroicon-o-arrow-path-rounded-square')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.layanans.index'))
                                ->url(fn (): string => LayananResource::getUrl()),
                            NavigationItem::make('Galeri')
                                ->icon('heroicon-o-photo')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.galeris.index'))
                                ->url(fn (): string => GaleriResource::getUrl()),
                            NavigationItem::make('Tentang Kami')
                                ->icon('heroicon-o-archive-box')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.tentang-kamis.index'))
                                ->url(fn (): string => TentangKamiResource::getUrl()),
                        ]),
                    NavigationGroup::make('Setting')
                        ->icon('heroicon-o-cog')
                        ->items([
                            NavigationItem::make('Users')
                                ->icon('heroicon-o-users')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.users.index'))
                                ->url(fn (): string => UserResource::getUrl()),
                            NavigationItem::make('Roles')
                                ->icon('heroicon-o-user-group')
                                ->isActiveWhen(fn (): bool => request()->routeIs([
                                    'filament.admin.resources.roles.index',
                                    'filament.admin.resources.roles.create',
                                    'filament.admin.resources.roles.view',
                                    'filament.admin.resources.roles.edit'
                                ]))
                                ->url(fn (): string => '/admin/roles'),
                            NavigationItem::make('Permissions')
                                ->icon('heroicon-o-lock-closed')
                                ->isActiveWhen(fn (): bool => request()->routeIs([
                                    'filament.admin.resources.permissions.index',
                                    'filament.admin.resources.permissions.create',
                                    'filament.admin.resources.permissions.view',
                                    'filament.admin.resources.permissions.edit'
                                ]))
                                ->url(fn (): string => '/admin/permissions'),

                        ]),
                ]);
            })
            // ->viteTheme('resources/css/filament/admin/theme.css')
        ;
    }
}
