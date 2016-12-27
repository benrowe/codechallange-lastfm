<?php

namespace App\Services\LastFm\Api;

use App\Services\LastFm\Response\AbstractResponse;

/**
 * Provides paginated result set functionality to the lastfm api components
 *
 * @package App\Services\LastFm\Api
 */
trait TraitSupportsPagintation
{
    private function buildPaginationParams($params)
    {
        if (!isset($params['limit'])) {
            $params['limit'] = $this->client->getOption('pagination.limit', 5);
        }
        if (!isset($params['page']) || $params['page'] < 1) {
            $params['page'] = 1;
        }

        return $params;
    }

    /**
     * @param $methodName
     * @param $params
     * @param $type
     * @param $key
     * @return \App\Services\LastFm\Response\ResultSet
     */
    private function buildPaginationResultSet($methodName, $params, $type, $key)
    {
        $params = $this->buildPaginationParams($params);
        $response = $this->client->request($methodName, $params);

        return AbstractResponse::makeResultSet($this->client, $response, $type, $key);
    }
}
