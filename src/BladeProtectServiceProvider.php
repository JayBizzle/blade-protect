<?php

namespace Jaybizzle\BladeProtect;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class BladeProtectServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../assets' => public_path('vendor/blade-protect'),
            ], 'public');

            $this->publishes([
                __DIR__.'/../database/migrations/created_protected_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_created_protected_table.php'),
            ], 'migrations');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $bladeCompiler->directive('protect', function ($arguments) {
                list($arg1, $arg2) = explode(',',str_replace(['(',')',' ', "'"], '', $arguments));

                return '<?php echo "<input class=\"__blade_protect\" type=\"hidden\" value=\"'.$arg1.':'.$arg2.'\">"; ?>';
            });

            $bladeCompiler->if('protected', function ($name, $identifier) {

                static $result = [];

                if (isset($result[$name][$identifier])) {
                    return $result[$name][$identifier];
                }

                return $result[$name][$identifier] = \Jaybizzle\BladeProtect\Models\Protect::query()
                    ->where([
                        'name' => $name,
                        'identifier' => $identifier,
                    ])
                    ->where('updated_at', '>=', now()->subSeconds(20))
                    ->where('user_id', '!=', auth()->user()->getKey())
                    ->exists();
            });
        });
    }
}
