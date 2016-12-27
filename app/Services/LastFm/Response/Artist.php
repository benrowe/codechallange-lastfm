<?php

namespace App\Services\LastFm\Response;

class Artist extends AbstractResponse
{
    const IMAGE_SIZE_SMALL = 'small';
    const IMAGE_SIZE_MEDIUM = 'medium';
    const IMAGE_SIZE_LARGE = 'large';
    const IMAGE_SIZE_EXTRA_LARGE = 'extralarge';
    const IMAGE_SIZE_MEGA = 'mega';

    /**
     * Absolute url to image resource for specified size
     *
     * @param string $size See IMAGE_SIZE_*
     * @return string|null
     */
    public function image($size)
    {
        foreach ($this->image as $img) {
            if ($img['size'] === $size) {
                return $img['#text'];
            }
        }
        return null;
    }

    public function topTracks($limit = 10):ResultSet
    {
        return $this->client->artist->topTracks($this->mbid, ['limit' => $limit]);
    }
}
