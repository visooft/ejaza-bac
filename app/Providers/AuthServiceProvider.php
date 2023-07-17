<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if(app()->getLocale() == "ar")
        {
            foreach (config('global_ar.premissions') as $abiltiy => $value) {
                Gate::define($abiltiy , function($auth) use ($abiltiy){
                    return $auth->hasAbility($abiltiy);
                });
            }
        }
        else {
            foreach (config('global_en.premissions') as $abiltiy => $value) {
                Gate::define($abiltiy , function($auth) use ($abiltiy){
                    return $auth->hasAbility($abiltiy);
                });
            }
        }
    }
}
