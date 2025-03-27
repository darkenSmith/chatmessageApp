<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessMessage;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate(['content' => 'required|string']);

        $message = Message::create([
            'user_id' => $request->user()->id,
            'content' => $request->input('content'),
            'status'  => 'pending'
        ]);

        $job = new ProcessMessage($message);
        dispatch($job);

        return response()->json($message, 201); // Returns a JSON response with status code 201
    }
}
