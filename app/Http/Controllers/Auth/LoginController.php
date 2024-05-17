<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
{
    $this->middleware('guest')->except('logout');
}

    public function redirectToFacebook()
    {
        \Log::info('redirectToFacebook method called'); // Debugging log
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        $existingUser = User::where('email', $facebookUser->getEmail())->first();

        if ($existingUser) {
            $existingUser->facebook_token = $facebookUser->token;
            $existingUser->save();
            Auth::login($existingUser, true);
        } else {
            $newUser = new User;
            $newUser->name = $facebookUser->getName();
            $newUser->email = $facebookUser->getEmail();
            $newUser->facebook_id = $facebookUser->getId();
            $newUser->facebook_token = $facebookUser->token;
            $newUser->save();
            Auth::login($newUser, true);
        }

        return redirect()->intended($this->redirectTo);
    }

    public function showEnterEmailForm()
{
    return view('auth.enter-email');
}

public function handleEnterEmailForm(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:users,email',
    ]);

    $user = Auth::user();
    $user->email = $request->email;
    $user->save();

    return redirect($this->redirectTo);
}

}
