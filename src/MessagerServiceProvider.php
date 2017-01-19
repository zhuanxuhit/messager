<?php namespace Nt\Messager;

use Illuminate\Support\ServiceProvider;

class MessagerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom( __DIR__ . '/../migrations' );

        $this->publishes( [
                              __DIR__ . '/../tests/MessageAccessibleTest.php'   => base_path( 'tests/MessageAccessibleTest.php' ),
                              __DIR__ . '/../tests/MessagerCreatorTest.php.php' => base_path( 'tests/MessagerCreatorTest.php.php' ),
                              __DIR__ . '/../tests/SubscriptionHandlerTest.php' => base_path( 'tests/SubscriptionHandlerTest.php' ),
                          ]
        );
        $this->publishes( [
                              __DIR__ . '/../config/messager.php' => config_path( 'messager.php' ),
                          ], 'config' );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        Subscription::$reasonAction = config('messager.reasonAction');
    }
}