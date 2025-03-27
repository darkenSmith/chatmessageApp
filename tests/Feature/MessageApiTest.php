<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_sending_message(): void
    {
        $user = User::factory()->create();

        $this->post('api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->post('api/messages', [
            'user_id' => $user->id,
            'content' => 'Hello world'
        ]);

        var_dump($response->getContent());

        $response->assertStatus(200);
        $response->assertJson([
            "user_id" => $user->id,
            "content" => "Hello world",
            "status" => "pending"
        ]);
    }

    public function test_see_all_messages(): void
    {
        Message::factory()->count(10)->create();
        $response = $this->get('api/messages');

        $response->assertStatus(200);
        $response->assertJsonCount(10, 'messages');
    }
}
