<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Forms\SearchForm;


/**
 * Class DefaultController
 *
 * @package App\Http\Controllers
 */
class DefaultController extends AbstractController
{
    /**
     * Load the application homepage
     */
    public function actionIndex()
    {
        $searchForm = new SearchForm;

        if ($this->hasRequestParam('SearchForm')) {
            $searchForm->fill($this->getRequestParam('SearchForm'));
        }

        return $this->view('default', [
            'countries' => Country::all(),
            'model' => $searchForm,
            'results' => $searchForm->isSearchable() ? $searchForm->results($this->getRequestParam('page', 1)) : null,
        ]);
    }
}
