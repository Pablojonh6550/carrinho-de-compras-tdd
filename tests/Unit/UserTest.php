<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $user = \App\Models\User::factory()->create();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
