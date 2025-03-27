<?php

use Illuminate\Support\Facades\Broadcast;

// Register broadcasting auth routes with Sanctum
Broadcast::routes(['middleware' => ['auth:sanctum']]);

Broadcast::channel('user.{userId}', function ($user, $userId) {
    \Log::info("Authorizing channel for user: {$user->id}");
    return (int) $user->id === (int) $userId;
});
