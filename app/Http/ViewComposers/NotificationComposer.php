<?php
 
namespace App\Http\ViewComposers;

use App\Models\Post;
use Illuminate\View\View;
use Auth;

class NotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    
    public function compose(View $view)
    {
        if (Auth::check()) {
            $notifications = Auth::user()->notifications()->get();
        }
        $view->with('notifications', $notifications);
    }
}
