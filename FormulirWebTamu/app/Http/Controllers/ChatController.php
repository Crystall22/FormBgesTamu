<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $perPage = 10; // jumlah user per halaman

        $users = User::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%"))
            ->when($role, fn($q) => $q->where('role', $role))
            ->where('id', '!=', auth()->id())
            ->orderBy('role')
            ->orderBy('name')
            ->paginate($perPage)
            ->appends(['search' => $search, 'role' => $role]);

        $roles = User::select('role')->distinct()->pluck('role');

        // AJAX response for real-time search/sort & pagination
        if ($request->ajax()) {
            $html = view('partials.chat-user', compact('users'))->render();
            $pagination = $users->links()->render();
            return response()->json(['html' => $html, 'pagination' => $pagination]);
        }

        return view('chat.index', compact('users', 'roles', 'search', 'role'));
    }


    public function chatWithUser($id)
    {
        $user = User::findOrFail($id);

        // Tandai pesan masuk sebagai sudah dibaca
        ChatMessage::where('from_user_id', $id)
            ->where('to_user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = ChatMessage::where(function ($q) use ($id) {
            $q->where('from_user_id', auth()->id())->where('to_user_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('from_user_id', $id)->where('to_user_id', auth()->id());
        })
            ->orderBy('created_at')
            ->get();

        return view('chat.chat', compact('user', 'messages'));
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        $chat = ChatMessage::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $id,
            'message' => $request->message,
            'image_path' => $imagePath,
            'is_read' => false,
        ]);
        return redirect()->route('chat.user', $id);
    }

    public function unreadCount()
    {
        $count = ChatMessage::where('to_user_id', auth()->id())->where('is_read', false)->count();
        $latest = ChatMessage::where('to_user_id', auth()->id())->where('is_read', false)->latest()->first();
        return response()->json([
            'count' => $count,
            'new_message' => $latest ? true : false,
            'text' => $latest ? ($latest->fromUser->name . ': ' . ($latest->message ?? 'Mengirim gambar')) : '',
        ]);
    }

    public function unreadList()
    {
        $messages = ChatMessage::where('to_user_id', auth()->id())->where('is_read', false)->latest()->take(10)->get();
        $html = '';
        foreach ($messages as $msg) {
            $html .= '<div class="mb-2"><b>' . $msg->fromUser->name . ':</b> ' . ($msg->message ?? '[Gambar]') . '</div>';
        }
        if (!$html)
            $html = '<div class="text-muted">Tidak ada notifikasi baru.</div>';
        return response()->json(['html' => $html, 'count' => $messages->count()]);
    }

    public function fetchMessages($id)
    {
        $messages = ChatMessage::where(function ($q) use ($id) {
            $q->where('from_user_id', auth()->id())->where('to_user_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('from_user_id', $id)->where('to_user_id', auth()->id());
        })
            ->orderBy('created_at')
            ->get();

        $html = view('partials.messages', compact('messages', 'id'))->render();
        return response()->json(['html' => $html]);
    }
}
