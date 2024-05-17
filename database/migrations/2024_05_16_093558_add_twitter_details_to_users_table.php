<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'twitter_location')) {
                $table->string('twitter_location')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_description')) {
                $table->text('twitter_description')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_url')) {
                $table->string('twitter_url')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_followers_count')) {
                $table->integer('twitter_followers_count')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_friends_count')) {
                $table->integer('twitter_friends_count')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_listed_count')) {
                $table->integer('twitter_listed_count')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_favourites_count')) {
                $table->integer('twitter_favourites_count')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_statuses_count')) {
                $table->integer('twitter_statuses_count')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_verified')) {
                $table->boolean('twitter_verified')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_profile_image_url')) {
                $table->string('twitter_profile_image_url')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_profile_banner_url')) {
                $table->string('twitter_profile_banner_url')->nullable();
            }
            if (!Schema::hasColumn('users', 'twitter_created_at')) {
                $table->timestamp('twitter_created_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'twitter_location')) {
                $table->dropColumn('twitter_location');
            }
            if (Schema::hasColumn('users', 'twitter_description')) {
                $table->dropColumn('twitter_description');
            }
            if (Schema::hasColumn('users', 'twitter_url')) {
                $table->dropColumn('twitter_url');
            }
            if (Schema::hasColumn('users', 'twitter_followers_count')) {
                $table->dropColumn('twitter_followers_count');
            }
            if (Schema::hasColumn('users', 'twitter_friends_count')) {
                $table->dropColumn('twitter_friends_count');
            }
            if (Schema::hasColumn('users', 'twitter_listed_count')) {
                $table->dropColumn('twitter_listed_count');
            }
            if (Schema::hasColumn('users', 'twitter_favourites_count')) {
                $table->dropColumn('twitter_favourites_count');
            }
            if (Schema::hasColumn('users', 'twitter_statuses_count')) {
                $table->dropColumn('twitter_statuses_count');
            }
            if (Schema::hasColumn('users', 'twitter_verified')) {
                $table->dropColumn('twitter_verified');
            }
            if (Schema::hasColumn('users', 'twitter_profile_image_url')) {
                $table->dropColumn('twitter_profile_image_url');
            }
            if (Schema::hasColumn('users', 'twitter_profile_banner_url')) {
                $table->dropColumn('twitter_profile_banner_url');
            }
            if (Schema::hasColumn('users', 'twitter_created_at')) {
                $table->dropColumn('twitter_created_at');
            }
        });
    }
};
