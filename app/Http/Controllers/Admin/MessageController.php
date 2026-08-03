<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('action') === 'delete' && $request->has('id')) {
            Message::find($request->id)?->delete();
            return redirect()->route('admin.messages.index')->with('success', 'Message deleted successfully.');
        }

        $page = 'messages';
        $messages = Message::orderBy('created_at', 'desc')->get();
        return view('admin.messages', compact('page', 'messages'));
    }
}
