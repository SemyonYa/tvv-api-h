<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property int $price
 * @property int $sequence
 * @property int $product_category_id
 * @property int|null $product_subject_id
 * @property int $is_visible
 *
 * @property ProductCategory $productCategory
 * @property ProductImage[] $productImages
 * @property ProductSubject $productSubject
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_en', 'description', 'description_en', 'product_category_id'], 'required'],
            [['description', 'description_en'], 'string'],
            [['price', 'sequence', 'product_category_id', 'product_subject_id', 'is_visible'], 'integer'],
            [['name', 'name_en'], 'string', 'max' => 200],
            [['product_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['product_category_id' => 'id']],
            [['product_subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductSubject::className(), 'targetAttribute' => ['product_subject_id' => 'id']],
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
            'description' => 'Description',
            'description_en' => 'Description En',
            'price' => 'Price',
            'sequence' => 'Sequence',
            'product_category_id' => 'Product Category ID',
            'product_subject_id' => 'Product Subject ID',
            'is_visible' => 'Is Visible',
        ];
    }

    /**
     * Gets query for [[ProductCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category_id']);
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductSubject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductSubject()
    {
        return $this->hasOne(ProductSubject::className(), ['id' => 'product_subject_id']);
    }

    public function getImages()
    {
        return $this->hasMany(Image::class, ['id' => 'image_id'])
            ->viaTable('product_image', ['product_id' => 'id']);
    }

    public function fields()
    {
        $fields = array_merge(parent::fields(), ['images']);
        // unset($fields['i1'], $fields['i2'], $fields['i3'], $fields['i4'], $fields['i5'], $fields['i6']);
        return $fields;
    }
}
