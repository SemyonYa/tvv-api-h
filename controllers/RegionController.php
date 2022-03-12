<?php

namespace app\controllers;

use app\controllers\abstractions\RestController;
use Yii;

class RegionController extends RestController
{
    public $modelClass = 'app\models\Region';
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['delete']);

        return $actions;
    }

    // public function actionUpdateImageSet($id)
    // {
    //     $id *= 1;
    //     $ids = Yii::$app->request->post('ids');

    //     $product_images = [];
    //     foreach ($ids as $image_id) {
    //         $product_images[] = [$id, $image_id];
    //     }

    //     Yii::$app->db->createCommand()
    //         ->delete('product_image', 'product_id = :product_id', [':product_id' => $id])
    //         ->execute();

    //     if (count($product_images)) {
    //         Yii::$app->db->createCommand()
    //             ->batchInsert('product_image', ['product_id', 'image_id'], $product_images)
    //             ->execute();
    //     }

    //     return;
    // }
}
