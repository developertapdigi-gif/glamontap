<?php

namespace App\Http\Controllers\Tradie;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('receiver_id', Auth::id())
            ->latest()->paginate(20);
        return view('tradie.notifications.index', compact('notifications'));
    }
}
