<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
use App\Helpers\RoleHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Register Blade directive for role display
        Blade::directive('displayRole', function ($expression) {
            return "<?php echo App\Helpers\RoleHelper::displayRole($expression); ?>";
        });
    }
}
