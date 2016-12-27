<?php

namespace App\Models\Forms;

use App\Models\AbstractModel;
use App\Models\Country;
use App\Services\LasfFm\Client;

/**
 *
 * @property Country country
 * @package App\Models
 */
class SearchForm extends AbstractModel
{
    /**
     * Default attributes
     * @var array
     */
    protected $attributes = ['country' => 'au'];

    /**
     * Calculate the result set based on the current state of the object
     *
     * @return ResultSet
     */
    public function results()
    {
        $country = $this->country;
        $client = $this->getLastFmApi();
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
    public function getLastFmApi()
    {
        return \App\app()->get('lastfm');
    }
}
