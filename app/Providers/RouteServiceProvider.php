<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */


    public function boot(): void
    {
        try {
            $rentalOwners = User::where('user_type', 'rental_owner')->get();
            view()->share('rentalOwners', $rentalOwners);
        
            $users = User::where('user_type', 'tenant')->get();
	    view()->share('user', $users);

	 $admins = User::where('user_type', 'admin')->get();
	    view()->share('admins', $admins);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error sharing data with views: ' . $e->getMessage());
        }
        
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
