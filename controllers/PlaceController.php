<?php

namespace app\controllers;

use app\controllers\abstractions\RestController;

class PlaceController extends RestController
{
    public $modelClass = 'app\models\Place';
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete']);
        // unset($actions['create'], $actions['update'], $actions['index']);

        return $actions;
    }
}
