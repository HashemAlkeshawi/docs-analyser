<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ScrapeController extends Controller
{
    public function scrape(Request $request)
    {
        $url = $request->input('url');
        $limit = $request->input('limit', 10);
        if (!$url) {
            return response()->json(['error' => 'Missing url parameter'], 400);
        }
        $exitCode = Artisan::call('docs:scrape', [
            'url' => $url,
            '--limit' => $limit,
        ]);
        $output = Artisan::output();
        return response()->json([
            'exit_code' => $exitCode,
            'output' => $output,
        ]);
    }
}
