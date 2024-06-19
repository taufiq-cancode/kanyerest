<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Cache::remember('all_quotes', 60, function () {
            return $this->fetchAllQuotes();
        });

        $randomQuotes = $this->getRandomQuotes($quotes);

        return view('quotes', compact('randomQuotes'));
    }

    public function refresh()
    {
        $quotes = Cache::remember('all_quotes', 60, function () {
            return $this->fetchAllQuotes();
        });

        $randomQuotes = $this->getRandomQuotes($quotes);

        return response()->json($randomQuotes);
    }

    private function fetchAllQuotes()
    {
        $response = Http::get('https://api.kanye.rest/quotes');
        return $response->json();
    }

    private function getRandomQuotes($quotes, $count = 5)
    {
        return collect($quotes)->random($count);
    }
}
