<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $notifs = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($n) {
                return [
                    'message' => $n->message,
                    'created_at' => $n->created_at->format('d-m-Y H:i'),
                    'form_id' => $n->form_id,
                ];
            });
        $unread = Notification::where('user_id', auth()->id())->whereNull('read_at')->count();
        return response()->json(['list' => $notifs, 'unread' => $unread]);
    }
    public function page()
    {
        $notifs = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('notifications.page', compact('notifs'));
    }
}
