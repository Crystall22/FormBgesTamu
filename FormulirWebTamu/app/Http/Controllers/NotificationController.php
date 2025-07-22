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
        $notifs = auth()->user()->notifications()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($n) {
                return [
                    'message' => $n->data['message'] ?? '',
                    'created_at' => $n->created_at->format('d-m-Y H:i'),
                    'form_id' => $n->data['form_id'] ?? null,
                ];
            });
        $unread = auth()->user()->unreadNotifications()->count();
        return response()->json(['list' => $notifs, 'unread' => $unread]);
    }
    public function page()
    {
        $notifs = auth()->user()->notifications()->orderBy('created_at', 'desc')->paginate(20);
        return view('notifications.page', compact('notifs'));
    }
    public function read($notifId)
    {
        $notif = auth()->user()->notifications()->where('id', $notifId)->first();
        if ($notif) {
            $notif->markAsRead();
        }
        return redirect()->back();
    }
    public function delete($id)
    {
        $notif = auth()->user()->notifications()->where('id', $id)->first();
        if ($notif)
            $notif->delete();
        return back();
    }
}
