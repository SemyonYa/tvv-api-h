<?php

namespace app\controllers;

use app\controllers\abstractions\RestController;
use app\models\Item;
use app\models\Product;
use app\models\ProductCategory;
use app\models\ProductSubject;

class DataController extends RestController
{
    public $modelClass = 'app\models\Item';
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['index']);

        return [];
        return $actions;
    }

    public function actionLanding()
    {
        return Item::find()->orderBy('sequence ASC')->all();
    }

    public function actionCatalog()
    {
        $categories = ProductCategory::find()->asArray()->all();
        foreach ($categories as $key => $_) {
            unset($categories[$key]['products']);
        }
        return [
            'categories' => $categories,
            'subjects' => ProductSubject::find()->all(),
            'products' => Product::find()->all(),
        ];
    }
}
