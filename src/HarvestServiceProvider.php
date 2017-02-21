<?php
/**
 * Laravel IDE Helper Generator
 *
 * @author    Daniel Twigg <dtwigg1990@gmail.com>
 * @copyright 2017 Daniel Twigg (https://danieltwigg.co.uk)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/barryvdh/laravel-ide-helper
 */

namespace Djam90\Harvest;

use Illuminate\Support\ServiceProvider;

class HarvestServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/harvest.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('harvest.php');
        } else {
            $publishPath = base_path('config/harvest.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/harvest.php';
        $this->mergeConfigFrom($configPath, 'harvest');

        $this->app->singleton(
            HarvestApi::class,
            function ($app) {
                return new HarvestApi($app['config']);
            }
        );

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [HarvestApi::class];
    }
}