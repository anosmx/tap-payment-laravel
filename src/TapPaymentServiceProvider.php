<?php

namespace Anosmx\TapPayment;

use Illuminate\Support\ServiceProvider;

class TapPaymentServiceProvider extends ServiceProvider
{
    // bootstrap web services
    // listen for events
    // publish configuration files or database migrations
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/tap_payment.php'  => config_path('tap_payment.php')
        ], 'tap-payment-config');
    }

    // extend functionality from other classes
    // register service providers
    // create singleton classes
    public function register()
    {
        $this->app->singleton(TapPayment::class, function () {
            return new TapPayment();
        });

        // Facade alias
        $this->app->alias(Subscription::class, 'tap_subscription');
        $this->app->alias(Charge::class, 'tap_charge');
    }
}