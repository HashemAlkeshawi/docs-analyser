<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\DocumentTitleExtractor;
use App\Services\DocumentContentExtractor;
use App\Services\DocumentClassifier;
use App\Models\Doc;
use GuzzleHttp\Client;

class ScrapeDocuments extends Command
{
    protected $signature = 'docs:scrape {url} {--limit=10}';
    protected $description = 'Scrape documents from a web page and store them as if uploaded';

    public function handle()
    {
        $url = $this->argument('url');
        $limit = (int) $this->option('limit');
        $client = new Client();
        $this->info("Fetching: $url");
        $res = $client->get($url);
        $html = (string) $res->getBody();

        // Simple regex for links to docs (pdf, doc, docx, txt)
        preg_match_all('/href=["\']([^"\']+\.(pdf|docx?|txt))["\']/i', $html, $matches);
        $links = array_unique($matches[1]);
        $links = array_slice($links, 0, $limit);
        $this->info("Found " . count($links) . " document links.");

        foreach ($links as $link) {
            $fileUrl = $link;
            if (!preg_match('/^https?:\/\//', $fileUrl)) {
                $fileUrl = rtrim($url, '/') . '/' . ltrim($fileUrl, '/');
            }
            $this->info("Downloading: $fileUrl");
            $fileRes = $client->get($fileUrl);
            $fileContent = $fileRes->getBody()->getContents();
            $filename = time() . '_' . basename($fileUrl);
            Storage::disk('public')->put('uploads/' . $filename, $fileContent);
            $fileType = pathinfo($filename, PATHINFO_EXTENSION);
            $title = pathinfo($filename, PATHINFO_FILENAME);
            $titleExtractor = new DocumentTitleExtractor();
            $generatedTitle = $titleExtractor->extract($filename, $fileType) ?? $title;
            $contentExtractor = new DocumentContentExtractor();
            $content = $contentExtractor->extract(storage_path('app/public/uploads/' . $filename), $fileType);
            $classifier = new DocumentClassifier();
            $classification = $classifier->classify($content);
            Doc::create([
                'title' => $title,
                'generated_name' => $generatedTitle,
                'file_path' => 'uploads/' . $filename,
                'content' => $content,
                'classification' => $classification,
                'file_type' => $fileType,
                'size' => strlen($fileContent),
                'uploaded_at' => now(),
                'description' => null,
            ]);
            $this->info("Stored: $filename");
        }
        $this->info('Scraping complete.');
    }
}
