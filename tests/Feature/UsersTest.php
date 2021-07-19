<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    public function test_get_request()
    {
        $response = $this->get('/api/users');

        $response->assertStatus(200);
    }
}
