<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpException;
use App\Services\LastFm\Response\Artist;

/**
 * ArtistController
 *
 * @package App\Http\Controllers
 */
class ArtistController extends AbstractController
{
    /**
     * Display details for the selected artist
     *
     * @param string $id music brains id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function actionView($id)
    {
        return $this->view('artist', ['artist' => $this->getModel($id)]);
    }

    /**
     * Load the artist model based on the supplied id
     *
     * @param string $id
     * @return Artist
     * @throws HttpException
     */
    private function getModel($id)
    {
        $model = \App\app()->get('lastfm')->artist->find($id);
        if (!$model) {
            throw new HttpException('Artist not found', 404);
        }
        return $model;
    }
}
