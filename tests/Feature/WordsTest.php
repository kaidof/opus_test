<?php

namespace Tests\Feature;

use League\Flysystem\Config;
use Tests\TestCase;

class WordsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShouldGetError()
    {
        $response = $this->get('/api/words');

        $response
            ->assertStatus(400)
            ->assertJson(['error' => 'Not valid URL']);
    }

    public function testShouldGetPlainText()
    {
        $response = $this->get('/api/words?url=https://raw.githubusercontent.com/mikeash/iphone-user-performance-tests/master/test-plan.txt');
        $response->assertStatus(201);

        // Test result
        $similarResponse = $this->get('/api/similar/close');
        $similarResponse
            ->assertStatus(200)
            ->assertJson([
                'Close',
                'last',
                'you',
                'so',
                'before',
                'can',
                'to',
                'on',
                'for',
                'this',
             ], false);
    }

    public function testShouldGetHTML()
    {
        $response = $this->get('/api/words?url=http://www.brainjar.com/java/host/test.html');
        $response->assertStatus(201);

        // Test result
        $similarResponse = $this->get('/api/similar/is');
        $similarResponse
            ->assertStatus(200)
            ->assertJson([
                'is',
                'This',
                'a',
                'file',
                'very',
                'HTML',
                'simple',
            ], false);

        $similarResponse = $this->get('/api/similar/not_found');
        $similarResponse
            ->assertStatus(200)
            ->assertJson([
                'file',
                'This',
                'is',
                'a',
                'very',
                'simple',
                'HTML',
            ]);
    }

    public function testShouldFailWhenNoSimilarityEngineSet()
    {
        config()->set('services.similarity.engine', '__temp__');

        $response = $this->get('/api/similar/test');
        $response
            ->assertStatus(500)
            ->assertJson([
                'error' => 'Similarity engine is not defined!'
            ]);
    }

}
