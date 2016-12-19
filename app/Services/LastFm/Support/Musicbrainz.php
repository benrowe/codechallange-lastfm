<?php

namespace App\Services\LastFm\Support;

/**
 * Musicbrainz
 *
 * Simple support class to help verify musicbrainz related data
 *
 * @package App\Services\LastFm\Support
 */
class Musicbrainz
{
    public function isValidId($reference)
    {
        // verify hex characters in specific patter (8-4-4-4-12)
        return (bool)preg_match("/^[a-f\d]{8}(-[a-f\d]{4}){3}-[a-f\d]{12}$/", trim($reference));
    }
}
