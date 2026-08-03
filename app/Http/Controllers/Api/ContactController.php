<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'nullable|string',
            'voice' => 'nullable|file|mimes:webm,mp3,wav,ogg,mp4|max:10240',
        ]);

        $voicePath = null;
        if ($request->hasFile('voice')) {
            $voicePath = $request->file('voice')->store('voices', 'public');
        }

        Message::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'] ?? '',
            'voice_path' => $voicePath,
            'is_read' => false
        ]);

        return response()->json(['success' => true, 'message' => 'Message sent successfully.']);
    }
}
