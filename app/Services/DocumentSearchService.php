<?php

namespace App\Services;

use App\Models\Doc;

class DocumentSearchService
{
    /**
     * Search documents by content (case-insensitive, partial match).
     *
     * @param string $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchByContent(string $query)
    {
        return Doc::where('content', 'LIKE', "%{$query}%")->get();
    }
}
