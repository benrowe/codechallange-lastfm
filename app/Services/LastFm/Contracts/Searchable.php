<?php

namespace App\Services\LastFm\Contracts;

use App\Services\LastFm\SearchRequest;

/**
 * Searchable Interface
 *
 * @package App\Services\LastFm
 */
interface Searchable
{
    public function search(SearchRequest $request):ResultSet;
}
