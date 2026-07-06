<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
  public function redirect(): RedirectResponse
  {
    return Socialite::driver('google')->redirect();
  }

  public function callback(): RedirectResponse
  {
    $googleUser = Socialite::driver('google')->user();

    $user = User::where('provider', 'google')
      ->where('provider_id', $googleUser->getId())
      ->first();

    if (!$user) {
      $user = User::where('email', $googleUser->getEmail())->first();

      if ($user) {
        $user->provider = 'google';
        $user->provider_id = $googleUser->getId();
        $user->save();
      } else {
        $user = User::create([
          'name' => $googleUser->getName() ?? explode('@', $googleUser->getEmail())[0],
          'email' => $googleUser->getEmail(),
          'password' => Str::random(32),
          'provider' => 'google',
          'provider_id' => $googleUser->getId(),
          'email_verified_at' => now(),
        ]);
      }
    }

    Auth::login($user);
    request()->session()->regenerate();

    return redirect()->intended(route('home'));
  }
}
