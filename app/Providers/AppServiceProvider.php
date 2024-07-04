<?php

namespace App\Providers;

use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use App\Services\CurrencyConverter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class
AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartRepository::class,function (){
            return new CartModelRepository();
        });
        $this->app->bind('currency.converter',function (){
            return new CurrencyConverter(config('services.currency.api_key'));
        });
        $this->app->bind('stripe.client', function() {
            return new \Stripe\StripeClient(config('services.stripe.secret_key'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Validator::extend('filter',function ($attribute,$value,$params){
            return ! in_array(strtolower($value),$params);
        },'this name is forbiden ');
        Paginator::useBootstrap();
        JsonResource::withoutWrapping();
    }

}
