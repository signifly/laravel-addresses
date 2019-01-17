<?php

namespace Signifly\Addresses;

use Illuminate\Support\ServiceProvider;

class AddressesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/addresses.php' => config_path('addresses.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/addresses.php', 'addresses');

        if (! class_exists('CreateAddressesTable')) {
            $timestamp = date('Y_m_d_His', time());
            $table = config('addresses.table_name');

            $this->publishes([
                __DIR__.'/../migrations/create_addresses_table.php.stub' => database_path("/migrations/{$timestamp}_create_{$table}_table.php"),
            ], 'migrations');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
