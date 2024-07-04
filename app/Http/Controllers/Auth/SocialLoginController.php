<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try
        {
            $provider_user = Socialite::driver($provider)->user();
            $user = User::query()->where([
                'provider' => $provider,
                'provider_id' => $provider_user->id
            ])->first();
            if (!$user) {
                $user = User::query()->create([
                    'name' => $provider_user->getName(),
                    'email' => $provider_user->getEmail(),
                    'password' => Hash::make(Str::random(9)),
                    'provider' => $provider,
                    'provider_id' => $provider_user->id,
                    'provider_token' => $provider_user->token
                ]);
            }
            Auth::login($user);
            return redirect()->route('home');
        } catch (\Throwable $throwable) {
            return redirect()->route('login')
                ->withErrors(['email'=>$throwable->getMessage()]);

        }
    }
}
