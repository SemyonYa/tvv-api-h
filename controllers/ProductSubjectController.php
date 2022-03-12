<?php

namespace app\controllers;

use app\controllers\abstractions\RestController;

class ProductSubjectController extends RestController
{
    public $modelClass = 'app\models\ProductSubject';
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();

        // unset($actions['create'], $actions['update'], $actions['index']);

        return $actions;
    }
}
