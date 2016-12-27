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

        /**
         * !important
         * see method note below
         */
        $response = $this->fixLastFmPaginationBug($response, $key);

        return AbstractResponse::makeResultSet($this->client, $response, $type, $key);
    }

    /**
     * Note: LastFM's pagination mechanism is very broken! Requesting a limit & page does
     * not reply with the expected result, thus the following is a client side fix to ensure the result set is
     * correct.
     * The problem is the limit is ignored, and the result includes previous pages!
     * If they ever fix this problem, this 'hack' should not effect the result set
     *
     * @param $key
     * @return mixed
     */
    private function fixLastFmPaginationBug($response, $key)
    {
        $data = array_pull($response, $key);
        if (count($data) > $this->client->getOption('pagination.limit', 5)) {
            $data = array_slice($data, $this->client->getOption('pagination.limit', 5) * -1);
        }

        array_set(
            $response,
            $key,
            $data
        );

        return $response;
    }
}
