<?php

namespace App\Providers;

use App\Actions\Fortify\AuthenticateUser;
use App\Actions\Fortify\CreateNewAdmin;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request = request();
        if ($request->is('admin/*'))
        {
            Config::set([
                'fortify.guard'=>'admin',
                'fortify.passwords'=>'admins',
                'fortify.prefix'=>'admin',
//                'fortify.home'=>'admin/dashboard'
            ]);
        }
        $this->app->instance(LoginResponse::class,new class implements LoginResponse{
            public function toResponse($request)
            {
                if ($request->user('admin'))
                {
                    return redirect()->intended('admin/dashboard');
                }
                return redirect()->intended('/');

            }
        });

        $this->app->instance(LogoutResponse::class,new class implements LogoutResponse{
            public function toResponse($request)
            {
                if ($request->is('admin/logout'))
                {
                    return redirect()->route('login');
                }
                return redirect()->route('home');
            }
        });

        $this->app->instance(RegisterResponse::class,new class implements RegisterResponse{
           public function toResponse($request)
           {
               if ($request->is('admin/register'))
               {
                   return redirect()->intended('admin/dashboard');
               }
               return redirect()->route('home');
           }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        if (Config::get('fortify.guard') == 'admin')
        {
            Fortify::createUsersUsing(CreateNewAdmin::class);
            Fortify::authenticateUsing([new AuthenticateUser,'authenticate']);
            Fortify::viewPrefix('auth.');

        }
        else
        {
            Fortify::createUsersUsing(CreateNewUser::class);
            Fortify::viewPrefix('front.auth.');
        }



//        Fortify::loginView(function (){
//            return view('auth.login');
//        });
//        Fortify::requestPasswordResetLinkView('auth.forgot-password');
//        Fortify::resetPasswordView('auth.reset-password');
//        Fortify::registerView('auth.register');
//        Fortify::confirmPasswordView('auth.confirm-password');
//        Fortify::verifyEmailView('auth.verify-email');
    }
}
