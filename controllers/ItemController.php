<?php

namespace app\controllers;

use app\controllers\abstractions\RestController;
use app\models\Item;
use app\models\ItemEn;
use Yii;
use yii\web\NotFoundHttpException;

class ItemController extends RestController
{
    public $modelClass = 'app\models\Item';
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['index']);

        return $actions;
    }

    public function actionIndex()
    {
        return Item::find()->orderBy('sequence ASC')->all();
    }

    public function actionCreate()
    {
        $item = new Item();

        $item->name = Yii::$app->request->post('name');
        $item->item_type_id = Yii::$app->request->post('item_type_id');
        $item->t1 = Yii::$app->request->post('t1');
        $item->t2 = Yii::$app->request->post('t2');
        $item->t3 = Yii::$app->request->post('t3');
        $item->t4 = Yii::$app->request->post('t4');
        $item->t5 = Yii::$app->request->post('t5');
        $item->t6 = Yii::$app->request->post('t6');
        $item->t7 = Yii::$app->request->post('t7');
        $item->t8 = Yii::$app->request->post('t8');
        $item->t9 = Yii::$app->request->post('t9');
        $item->t10 = Yii::$app->request->post('t10');
        $item->i1 = Yii::$app->request->post('i1_id');
        $item->i2 = Yii::$app->request->post('i2_id');
        $item->i3 = Yii::$app->request->post('i3_id');
        $item->i4 = Yii::$app->request->post('i4_id');
        $item->i5 = Yii::$app->request->post('i5_id');
        $item->i6 = Yii::$app->request->post('i6_id');
        $item->sequence = Yii::$app->request->post('sequence') * 1;

        $item_en = new ItemEn();

        $item_en->t1 = Yii::$app->request->post('t1_en');
        $item_en->t2 = Yii::$app->request->post('t2_en');
        $item_en->t3 = Yii::$app->request->post('t3_en');
        $item_en->t4 = Yii::$app->request->post('t4_en');
        $item_en->t5 = Yii::$app->request->post('t5_en');
        $item_en->t6 = Yii::$app->request->post('t6_en');
        $item_en->t7 = Yii::$app->request->post('t7_en');
        $item_en->t8 = Yii::$app->request->post('t8_en');
        $item_en->t9 = Yii::$app->request->post('t9_en');
        $item_en->t10 = Yii::$app->request->post('t10_en');
        $item_en->i1 = Yii::$app->request->post('i1_id_en');
        $item_en->i2 = Yii::$app->request->post('i2_id_en');
        $item_en->i3 = Yii::$app->request->post('i3_id_en');
        $item_en->i4 = Yii::$app->request->post('i4_id_en');
        $item_en->i5 = Yii::$app->request->post('i5_id_en');
        $item_en->i6 = Yii::$app->request->post('i6_id_en');

        $transaction = Item::getDb()->beginTransaction();
        try {
            $item->save();

            $item_en->item_id = $item->id;
            $item_en->save();

            $transaction->commit();

            return $item;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    public function actionUpdate($id)
    {
        $item = Item::findOne($id);
        if (!$item)
            throw new NotFoundHttpException();

        $item->name = Yii::$app->request->post('name');
        $item->item_type_id = Yii::$app->request->post('item_type_id');
        $item->t1 = Yii::$app->request->post('t1');
        $item->t2 = Yii::$app->request->post('t2');
        $item->t3 = Yii::$app->request->post('t3');
        $item->t4 = Yii::$app->request->post('t4');
        $item->t5 = Yii::$app->request->post('t5');
        $item->t6 = Yii::$app->request->post('t6');
        $item->t7 = Yii::$app->request->post('t7');
        $item->t8 = Yii::$app->request->post('t8');
        $item->t9 = Yii::$app->request->post('t9');
        $item->t10 = Yii::$app->request->post('t10');
        $item->i1 = Yii::$app->request->post('i1_id');
        $item->i2 = Yii::$app->request->post('i2_id');
        $item->i3 = Yii::$app->request->post('i3_id');
        $item->i4 = Yii::$app->request->post('i4_id');
        $item->i5 = Yii::$app->request->post('i5_id');
        $item->i6 = Yii::$app->request->post('i6_id');
        $item->sequence = Yii::$app->request->post('sequence') * 1;

        $item_en = ItemEn::findOne(['item_id' => $id]);

        $item_en->t1 = Yii::$app->request->post('t1_en');
        $item_en->t2 = Yii::$app->request->post('t2_en');
        $item_en->t3 = Yii::$app->request->post('t3_en');
        $item_en->t4 = Yii::$app->request->post('t4_en');
        $item_en->t5 = Yii::$app->request->post('t5_en');
        $item_en->t6 = Yii::$app->request->post('t6_en');
        $item_en->t7 = Yii::$app->request->post('t7_en');
        $item_en->t8 = Yii::$app->request->post('t8_en');
        $item_en->t9 = Yii::$app->request->post('t9_en');
        $item_en->t10 = Yii::$app->request->post('t10_en');
        $item_en->t10 = Yii::$app->request->post('t10_en');
        $item_en->i1 = Yii::$app->request->post('i1_id_en');
        $item_en->i2 = Yii::$app->request->post('i2_id_en');
        $item_en->i3 = Yii::$app->request->post('i3_id_en');
        $item_en->i4 = Yii::$app->request->post('i4_id_en');
        $item_en->i5 = Yii::$app->request->post('i5_id_en');
        $item_en->i6 = Yii::$app->request->post('i6_id_en');

        $transaction = Item::getDb()->beginTransaction();
        try {
            $item->save();
            $item_en->save();

            $transaction->commit();

            return $item;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
