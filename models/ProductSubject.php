<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_subject".
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property int $sequence
 *
 * @property Product[] $products
 */
class ProductSubject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_en'], 'required'],
            [['sequence'], 'integer'],
            [['name', 'name_en'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'name_en' => 'Name En',
            'sequence' => 'Sequence',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['product_subject_id' => 'id']);
    }
}
