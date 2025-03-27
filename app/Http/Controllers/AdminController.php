<?php

namespace App\Http\Controllers;

use App\Events\MessageProcessed;
use App\Jobs\ProcessMessage;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function index()
    {
        $messages = Message::where('status', 'pending')->with('user')->get();
        return view('admin.messages', compact('messages'));
    }

    public function confirmMessage(Message $message): RedirectResponse
    {
        $message->update(['status' => 'completed']);

        // Broadcast the event to notify the user
        broadcast(new MessageProcessed($message))->toOthers(); // Notify other clients

        return redirect()->back()->with('success', 'Message processed!');
    }
}
