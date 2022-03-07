<?php

namespace App\Providers;

use App\Http\ViewComposers\NotificationComposer;
use App\Models\Comment;
use App\Models\Reaction;
use App\Models\Relation;
use App\Models\User;
use App\Observers\CommentObserve;
use App\Observers\FriendObserve;
use App\Observers\ReactionObserve;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('app-layout.header', NotificationComposer::class);
        Paginator::useBootstrap();
        Comment::observe(CommentObserve::class);
        Reaction::observe(ReactionObserve::class);
        Relation::observe(FriendObserve::class);
    }
}
