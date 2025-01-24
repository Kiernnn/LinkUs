<?php

namespace App\Http\View;

use Illuminate\View\View;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;

class SidebarComposer
{
    public function compose(View $view)
    {
        $friendRequestCount = FriendRequest::where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        $view->with('friendRequestCount', $friendRequestCount);
    }
}
