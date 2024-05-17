<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Facebook\Facebook;
use Abraham\TwitterOAuth\TwitterOAuth;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'facebook_id', 'facebook_token',
        'twitter_id', 'twitter_token', 'twitter_token_secret', 'twitter_name',
        'twitter_profile_name', 'twitter_location', 'twitter_description', 'twitter_url',
        'twitter_followers_count', 'twitter_friends_count', 'twitter_listed_count',
        'twitter_favourites_count', 'twitter_statuses_count', 'twitter_verified',
        'twitter_profile_image_url', 'twitter_profile_banner_url', 'twitter_created_at'
    ];
// Method to get Facebook insights
    public function getFacebookInsights()
    {
        $fb = new Facebook([
            'app_id' => env('FACEBOOK_CLIENT_ID'),
            'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
            'default_graph_version' => 'v3.2',
        ]);

        try {
            $response = $fb->get('/me?fields=id,name,followers_count', $this->facebook_token);
            $user = $response->getGraphUser();
            return $user;
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // Handle response error
            return null;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // Handle SDK error
            return null;
        }
    }

    public function getTwitterInsights()
    {
        $connection = new TwitterOAuth(
            env('TWITTER_CLIENT_ID'),
            env('TWITTER_CLIENT_SECRET'),
            $this->twitter_token,
            $this->twitter_token_secret
        );

        // Log the API request to see the response
        $user = $connection->get("account/verify_credentials", ["include_entities" => true, "skip_status" => true, "include_email" => true]);

        if ($connection->getLastHttpCode() == 200) {
            // If the request was successful, log the user details
            \Log::info('Twitter user details:', (array) $user);

            $followers_count = $user->followers_count ?? 0;

            return [
                'name' => $user->name,
                'followers_count' => $followers_count,
            ];
        } else {
            // Log the error
            \Log::error('Error fetching Twitter user details:', (array) $user);
            \Log::error('Twitter API error response:', ['response' => $connection->getLastBody()]);

            return null;
        }
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
