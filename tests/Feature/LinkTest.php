<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LinkTest extends TestCase
{

    /**
     * A home page test.
     *
     * @return void
     */
    public function testHomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic store link test example.
     *
     * @return void
     */
    public function testStoreLink()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/', ['link' => 'https://laravel.com']);

        $response
            ->assertStatus(201)
            ->assertJson([
                'link' => 'https://laravel.com',
            ]);
    }

    /**
     * A basic store link test example.
     *
     * @return void
     */
    public function testStoreLinkFromBlackList()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/', ['link' => 'https://pornhub.com']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
            ]);
    }
}
