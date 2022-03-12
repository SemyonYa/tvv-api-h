<?php

namespace app\controllers;

use app\controllers\abstractions\RestController;

class ProductCategoryController extends RestController
{
    public $modelClass = 'app\models\ProductCategory';
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();

        // unset($actions['create'], $actions['update'], $actions['index']);

        return $actions;
    }
}
