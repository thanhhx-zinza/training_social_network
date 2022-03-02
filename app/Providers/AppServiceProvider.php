<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Reaction;
use App\Observers\CommentObserve;
use App\Observers\ReactionObserve;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
         Paginator::useBootstrap();
        Comment::observe(CommentObserve::class);
        Reaction::observe(ReactionObserve::class);
    }
}
