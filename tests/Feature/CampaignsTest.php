<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CampaignsTest extends TestCase
{
    public function test_get_request()
    {
        $response = $this->get('/api/campaigns');

        $response->assertStatus(200);
    }

    public function test_post_request_with_missing_data()
    {
        $response = $this->post('/api/campaigns');

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'author_id' => [
                        'The author id field is required.'
                    ],
                    'channel' => [
                        'The channel field is required.'
                    ],
                    'source' => [
                        'The source field is required.'
                    ],
                    'campaign_name' => [
                        'The campaign name field is required.'
                    ],
                    'target_url' => [
                        'The target url field is required.'
                    ],
                ]
            ]);
    }

    public function test_post_request_with_wrong_author_id()
    {
        $response = $this->postJson('/api/campaigns',[
            'author_id' => 0,
            'channel' => 'test',
            'source' => 'test',
            'campaign_name' => 'test',
            'target_url' => 'test.com'
        ]);

        $response->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'author_id' => [
                        'The selected author id is invalid.'
                    ]
                ]
            ]);
    }

    public function test_post_request_with_correct_data()
    {
        $response = $this->postJson('/api/campaigns',[
            'author_id' => 1,
            'channel' => 'test',
            'source' => 'test',
            'campaign_name' => 'test',
            'target_url' => 'test.com'
        ]);

        $response->assertStatus(201)
            ->assertExactJson(['created' => true]);
    }
}
