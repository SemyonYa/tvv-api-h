<?php

namespace app\controllers;

use app\controllers\abstractions\RestController;
use Yii;
use Throwable;
use yii\web\UploadedFile;

use app\models\Image;
use app\models\Product;
use app\models\UploadForm;

class ImageController extends RestController
{
    public $modelClass = 'app\models\Image';
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['index']);

        return $actions;
    }

    public function actionIndex()
    {
        // return Yii::$app->request->hostInfo;
        // return $_SERVER['HTTP_ORIGIN'];
        return Image::find()->where(['deleted' => 0])->orderBy('id DESC')->all();
    }

    public function actionCreate()
    {
        $images = [];
        $model = new UploadForm();

        try {
            if (Yii::$app->request->isPost) {
                $model->files = UploadedFile::getInstancesByName('files');
                if ($imageNames = $model->upload()) {
                    foreach ($imageNames as $name) {
                        $image = new Image($name);
                        if ($image->save()) {
                            $image->resizeAndSave();
                            $images[] = $image;
                        }
                    }
                    return $images;
                }
            }
        } catch (Throwable $th) {
            throw $th;
        }
        return false;
    }

    public function actionSetDeleted()
    {
        $ids = Yii::$app->request->post('ids');
        // return $ids;
        Image::updateAll(['deleted' => 1], ['in', 'id', $ids]);
        return true;
    }

    // public function actionForProduct($product_id)
    // {
    //     $images = [];
    //     $product = Product::findOne($product_id);
    //     foreach ($product->productImages as $i) {
    //         $images[] = $i->image;
    //     }
    //     return $images;
    // }
}
