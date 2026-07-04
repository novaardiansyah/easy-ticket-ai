<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisterLinkMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisterController extends Controller
{
  public function showRegistrationForm(): View
  {
    return view('auth.register');
  }

  public function sendRegistrationLink(Request $request): RedirectResponse
  {
    $request->validate([
      'email' => ['required', 'email'],
    ]);

    if (User::where('email', $request->email)->exists()) {
      return back()->withErrors([
        'email' => 'This email is already registered.',
      ]);
    }

    User::create([
      'name' => explode('@', $request->email)[0],
      'email' => $request->email,
      'password' => Hash::make(Str::random(16)),
      'email_verified_at' => null,
    ]);

    $url = URL::temporarySignedRoute(
      'register.setup',
      now()->addHours(24),
      ['email' => $request->email]
    );

    Mail::to($request->email)->send(new RegisterLinkMail($request->email, $url));

    return redirect()->route('register.success');
  }

  public function showSuccessPage(): View
  {
    return view('auth.register-success');
  }

  public function showSetupForm(Request $request): View|RedirectResponse
  {
    if (! $request->hasValidSignature()) {
      abort(403, 'Invalid or expired registration link.');
    }

    $email = $request->email;
    $user = User::where('email', $email)->first();

    if (! $user || $user->email_verified_at !== null) {
      return redirect()->route('login')->withErrors([
        'email' => 'Account setup already completed. Please log in.',
      ]);
    }

    $name = explode('@', $email)[0] ?? '';

    return view('auth.register-setup', [
      'email' => $email,
      'name' => $name,
    ]);
  }

  public function setupAccount(Request $request): RedirectResponse
  {
    $request->validate([
      'email' => ['required', 'email'],
      'name' => ['required', 'string', 'max:255'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $user = User::where('email', $request->email)
      ->whereNull('email_verified_at')
      ->first();

    if (! $user) {
      return redirect()->route('login')->withErrors([
        'email' => 'Account setup already completed or invalid registration link.',
      ]);
    }

    $user->name = $request->name;
    $user->password = Hash::make($request->password);
    $user->email_verified_at = now();
    $user->save();

    Auth::login($user);

    return redirect()->route('home');
  }
}
