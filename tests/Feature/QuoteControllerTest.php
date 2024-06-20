<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;

class QuoteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
    
    /** @test */
    public function it_displays_random_quotes_on_index()
    {
        $this->actingAs($this->user);

        $quotes = ['Quote 1', 'Quote 2', 'Quote 3', 'Quote 4', 'Quote 5', 'Quote 6'];
        Http::fake([
            'https://api.kanye.rest/quotes' => Http::response($quotes, 200),
        ]);

        Cache::shouldReceive('remember')
            ->once()
            ->with('all_quotes', 60, \Closure::class)
            ->andReturn($quotes);

        $response = $this->get('/quotes');

        $response->assertStatus(200);
        $response->assertViewHas('randomQuotes');
    }

    /** @test */
    public function it_refreshes_random_quotes_via_ajax()
    {
        $this->actingAs($this->user);

        $quotes = ['Quote 1', 'Quote 2', 'Quote 3', 'Quote 4', 'Quote 5', 'Quote 6'];
        Http::fake([
            'https://api.kanye.rest/quotes' => Http::response($quotes, 200),
        ]);

        Cache::shouldReceive('remember')
            ->once()
            ->with('all_quotes', 60, \Closure::class)
            ->andReturn($quotes);

        $response = $this->postJson('/quotes/refresh');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }
}
