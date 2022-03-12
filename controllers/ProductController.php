<?php

namespace app\controllers;

use app\controllers\abstractions\RestController;
use app\models\Product;
use app\models\ProductImage;
use Yii;

class ProductController extends RestController
{
    public $modelClass = 'app\models\Product';
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();

        // unset($actions['create'], $actions['update'], $actions['index']);

        return $actions;
    }

    // protected function verbs()

    // {

    //     return [

    //         'index' => ['GET', 'HEAD', 'OPTIONS'], //instead of  'index' => ['GET', 'HEAD']

    //         'view' => ['GET', 'HEAD', 'OPTIONS'],

    //         'create' => ['POST', 'OPTIONS'],

    //         'update' => ['PUT', 'PATCH', 'OPTIONS'],
    //         'update-image-set' => ['PUT', 'PATCH', 'OPTIONS'],

    //         'delete' => ['DELETE'],

    //     ];
    // }

    public function actionUpdateImageSet($id)
    {
        $id *= 1;
        $ids = Yii::$app->request->post('ids');

        $product_images = [];
        foreach ($ids as $image_id) {
            $product_images[] = [$id, $image_id];
        }

        Yii::$app->db->createCommand()
            ->delete('product_image', 'product_id = :product_id', [':product_id' => $id])
            ->execute();

        if (count($product_images)) {
            Yii::$app->db->createCommand()
                ->batchInsert('product_image', ['product_id', 'image_id'], $product_images)
                ->execute();
        }

        return;
    }
}
