<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        Mail::raw($validated['message'], function ($msg) use ($validated) {
            $msg->to('your-email@example.com')
                ->subject('[Contact] ' . $validated['subject'])
                ->replyTo($validated['email'], $validated['name']);
        });

        return back()->with('success', 'Pesan Anda telah dikirim!');
    }
}
