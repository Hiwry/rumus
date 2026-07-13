<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
                $dbSettings = \App\Models\SiteSetting::all()->pluck('value', 'key')->toArray();
                
                // Override configs
                if (isset($dbSettings['instagram_url'])) {
                    config(['services.instagram.url' => $dbSettings['instagram_url']]);
                }
                if (isset($dbSettings['whatsapp_url'])) {
                    config(['services.whatsapp.url' => $dbSettings['whatsapp_url']]);
                }
                if (isset($dbSettings['site_name'])) {
                    config(['app.name' => $dbSettings['site_name']]);
                }

                // Share globally with all views
                view()->share('siteSettings', $dbSettings);
            }

            if (\Illuminate\Support\Facades\Schema::hasTable('landing_images')) {
                $landingImages = \App\Models\LandingImage::all()->keyBy('key');
                view()->share('landingImages', $landingImages);
            }
        } catch (\Throwable $e) {
            // Avoid failing if migration/database doesn't exist
        }
    }
}
