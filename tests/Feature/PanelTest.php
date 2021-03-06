<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PanelTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStoreSuccess()
    {
        $response = $this->json('POST', '/api/panels', [
            'serial'    => 'abcdef0123456789',
            'longitude' => 25.000001,
            'latitude'  => 26.000002
        ]);

        $response->assertStatus(201);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStoreFailure()
    {
        $response = $this->json('POST', '/api/panels', [
            'serial'    => 'abcdef0123456789',
            'longitude' => 0
        ]);

        $response->assertStatus(422);
    }
}
