<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\IdentityProvider;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public  function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function oauthCallback($provider)
    {
        try {
            $socialUser = Socialite::with($provider)->user();
        } catch (\Throwable $th) {
            return redirect('/login')->withErrors(['oauth' => '予期せぬエラーが発生しました']);
        }
        // dd($socialUser);
        $identityProvider = IdentityProvider::firstOrNew(['id' => $socialUser->getId(), 'name' => $provider]);

        if ($identityProvider->exists) {
            $user = $identityProvider->user;
        } else {
            $user = new User([
                'name' => $socialUser->getNickname() ?? $socialUser->name,
            ]);

            DB::beginTransaction();
            try {
                $user->save();
                $user->identityProvider()->save($identityProvider);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()
                    ->route('login')
                    ->withErrors(['transaction_error' => '保存に失敗しました']);
            }
        }
        // ログイン
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
