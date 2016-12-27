<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpException;
use App\Services\LastFm\Response\Artist;

class ArtistController extends AbstractController
{
    public function actionView($id)
    {
        return $this->view('artist', ['artist' => $this->getModel($id)]);
    }

    /**
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
