<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function register()
    {
        parent::register();
        $this->app->bind('abilities',function (){
            return include base_path('app/data/abilities.php');
        });
    }
    public function boot(): void
    {

//        foreach($this->app->make('abilities') as $ability=>$value)
//        {
//            Gate::define($ability,function ($user) use ($ability){
//                return $user->hasAbility($ability);
//            });
//        }

    }
}
