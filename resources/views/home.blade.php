@extends('layouts.app')

@section('content')
<div class="container">
    <style>
        .table td {
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Greeting message -->
            <div class="alert alert-info" role="alert">
                Hey {{ Auth::user()->name }}!
            </div>

            <div class="card mb-4">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Facebook Insights</h4>
                    @if (Auth::user()->facebook_id)
                        <p>Connected to Facebook as {{ Auth::user()->name }}</p>
                        <p>Followers: {{ Auth::user()->getFacebookInsights()['followers_count'] }}</p>
                    @else
                    <div class="alert alert-info" role="alert">
                You haven't connected your Facebook account yet or we couldn't retrieve insights.
            </div>
                        <a href="{{ route('auth.facebook') }}" class="btn btn-primary">Connect Facebook</a>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Twitter Insights</div>

                <div class="card-body">
                    @if (Auth::user()->twitter_id)
                        <p>Connected to Twitter as {{ Auth::user()->twitter_profile_name }}</p>
                        <img src="{{ Auth::user()->twitter_profile_image_url }}" alt="Profile Image" class="img-thumbnail" style="width: 150px; height: 150px;">
                        <div class="alert alert-warning" role="alert">
                                Unable to fetch Your Followers count because of Privacy error.
                            </div>
                        <table class="table table-bordered table-responsive">
                            <tbody>
                                <tr>
                                    <th scope="row">Twitter Username</th>
                                    <td>{{ Auth::user()->twitter_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Twitter Profile Name</th>
                                    <td>{{ Auth::user()->twitter_profile_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Profile Image URL</th>
                                    <td><a href="{{ Auth::user()->twitter_profile_image_url }}" target="_blank">{{ Auth::user()->twitter_profile_image_url }}</a></td>
                                </tr>
                                <!-- Add more fields as they become available -->
                            </tbody>
                        </table>
                    @else
                    <div class="alert alert-info" role="alert">
                You haven't connected your X account yet or we couldn't retrieve insights.
            </div>
                        <a href="{{ route('auth.twitter') }}" class="btn btn-primary">Connect Twitter</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
