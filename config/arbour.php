<?php

//use App\Filament\Resources\UserManage\UserResource;
//use BezhanSalleh\FilamentShield\Resources\RoleResource;
//use Filament\Http\Middleware\Authenticate;
//use Filament\Http\Middleware\DisableBladeIconComponents;
//use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return [
    'api' => [
        'url' => env('API_URL'),
        'prefix' => env('API_PREFIX', '/api'),
        'enable_version_prefix' => true,

        'throttle' => [
            'enabled' => env('GLOBAL_API_RATE_LIMIT_ENABLED', true),
            'attempts' => env('GLOBAL_API_RATE_LIMIT_ATTEMPTS_PER_MIN', '30'),
            'expires' => env('GLOBAL_API_RATE_LIMIT_EXPIRES_IN_MIN', '1'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Filament v3 control panel settings
    |--------------------------------------------------------------------------
    |
    */
//    'panel' => [
//        'brand_name' => env('APP_NAME'),
//
//        'auth_guard' => env('FILAMENT_AUTH_GUARD', ''),
//
//        'domain' => env('FILAMENT_DOMAIN'),
//        'id' => env('FILAMENT_ID', 'panel'),
//        'path' => env('FILAMENT_PATH', 'panel'),
//        'home_url' => env('FILAMENT_PATH', 'panel'),
//
//        'colors' => [
//            'primary' => Filament\Support\Colors\Color::Green,
//        ],
//
//        'resources' => [
//            UserResource::class,
//            RoleResource::class,
//        ],
//
//        'pages' => [
//            Filament\Pages\Dashboard::class,
//        ],
//
//        'widgets' => [
//            Filament\Widgets\AccountWidget::class,
//        ],
//
//        'plugins' => [
//            BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
//                ->gridColumns([
//                    'default' => 2,
//                    'sm' => 1
//                ])
//                ->sectionColumnSpan(1)
//                ->checkboxListColumns([
//                    'default' => 1,
//                    'sm' => 2,
//                    'lg' => 3,
//                ])
//                ->resourceCheckboxListColumns([
//                    'default' => 1,
//                    'sm' => 2,
//                ]),
//        ],
//
//        'middleware' => [
//            EncryptCookies::class,
//            AddQueuedCookiesToResponse::class,
//            StartSession::class,
//            AuthenticateSession::class,
//            ShareErrorsFromSession::class,
//            VerifyCsrfToken::class,
//            SubstituteBindings::class,
//            DisableBladeIconComponents::class,
//            DispatchServingFilamentEvent::class,
//        ],
//
//        'authMiddleware' => [
//            Authenticate::class,
//        ],
//
//        'discover_pages' => [
//            'in' => app_path('Filament/Pages'),
//            'for' => 'App\Filament\Pages',
//        ],
//
//        'discover_resources' => [
//            'in' => app_path('Filament/Resources'),
//            'for' => 'App\Filament\Resources',
//        ],
//
//        'discover_widgets' => [
//            'in' => app_path('Filament/Widgets'),
//            'for' => 'App\Filament\Widgets',
//        ],
//
//        'user' => [
//            'model' => 'App\Models\User',
//            'slug' => 'management/users',
//            'group' => 'User Management',
//            'impersonate' => true,
//            'shield' => true,
//        ],
//    ],
];
