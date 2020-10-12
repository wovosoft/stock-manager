<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\Setting;
use Bluemmb\Faker\PicsumPhotosProvider;
use Faker\Generator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if ($this->app->runningInConsole()) {
            $faker = $this->app->make(Generator::class);
//            $faker->addProvider(new \Faker\Provider\Youtube($faker));
            $faker->addProvider(new PicsumPhotosProvider($faker));
        }

        if (!$this->app->runningInConsole()) {
            loadCachedSettingsInConfig();
            loadLanguagesInConfig();
        }
    }
}
