<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Import the correct Request class
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TestController extends Controller
{

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

    public function redirectToTwitter()
    {
        \Log::info('redirectToTwitter method called in TestController');
        return Socialite::driver('twitter-oauth-2')->redirect();
    }

   public function handleTwitterCallback()
{
    \Log::info('handleTwitterCallback method called in TestController');

    $twitterUser = Socialite::driver('twitter-oauth-2')->user();

    // Log the entire Twitter user object to inspect the available data
    \Log::info('Twitter user object:', (array) $twitterUser);

    // Get the current authenticated user
    $currentUser = Auth::user();

    if ($currentUser) {
        $currentUser->twitter_id = $twitterUser->getId();
        $currentUser->twitter_token = $twitterUser->token;
        $currentUser->twitter_token_secret = $twitterUser->refreshToken; // No tokenSecret provided
        $currentUser->twitter_name = $twitterUser->nickname; // Save the Twitter screen name
        $currentUser->twitter_profile_name = $twitterUser->name; // Save the Twitter profile name

        // Extract available fields from the response
        $userAttributes = $twitterUser->user;

        $currentUser->twitter_profile_image_url = $userAttributes['profile_image_url'] ?? $twitterUser->avatar;

        // Set unavailable fields to null
        $currentUser->twitter_location = null;
        $currentUser->twitter_description = null;
        $currentUser->twitter_url = null;
        $currentUser->twitter_followers_count = null;
        $currentUser->twitter_friends_count = null;
        $currentUser->twitter_listed_count = null;
        $currentUser->twitter_favourites_count = null;
        $currentUser->twitter_statuses_count = null;
        $currentUser->twitter_verified = null;
        $currentUser->twitter_profile_banner_url = null;
        $currentUser->twitter_created_at = null;
        
        $currentUser->save();
    }

    return redirect()->intended('/home');
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

    // Retrieve Twitter user data from the session
    $twitterUser = session('twitter_user');

    if (!$twitterUser) {
        return redirect('/login'); // Handle missing session data
    }

    $currentUser = Auth::user();

    if ($currentUser) {
        $currentUser->email = $request->email;
        $currentUser->twitter_id = $twitterUser['id'];
        $currentUser->twitter_token = $twitterUser['token'];
        $currentUser->twitter_token_secret = $twitterUser['token_secret'];
        $currentUser->twitter_name = $twitterUser['screen_name']; // Save the Twitter screen name
        $currentUser->save();
    }

    // Clear the session data
    session()->forget('twitter_user');

    return redirect('/home');
}


}
