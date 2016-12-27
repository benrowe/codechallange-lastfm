<?php

namespace App\Models\Forms;

use App\Models\AbstractModel;
use App\Models\Country;
use App\Services\LastFm\Client;

/**
 *
 * @property Country country
 * @package App\Models
 */
class SearchForm extends AbstractModel
{
    /**
     * Default attributes
     *
     * @var array
     */
    protected $attributes = ['country' => 'AU'];

    /**
     * Calculate the result set based on the current state of the object
     *
     * @param int $page
     * @return ResultSet
     */
    public function results($page = 1)
    {
        $client  = $this->getLastFmApi();

        return $client->geo->topArtists($this->country()->name, ['page' => $page]);
    }

    /**
     * Check the state of the SearchForm model to determine if a search could
     * return possible results
     *
     * @return boolean [description]
     */
    public function isSearchable()
    {
        return count(array_filter($this->attributes)) > 0;
    }

    /**
     * Get the country model
     *
     * @return Country|null
     */
    public function country()
    {
        if ($this->country) {
            return Country::findById($this->country);
        }

        return null;
    }

    /**
     * Get the LastFm Api Client
     *
     * @return Client
     * @todo move this app container injection
     */
    public function getLastFmApi(): Client
    {
        return \App\app()->get('lastfm');
    }
}
