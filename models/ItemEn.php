<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item_en".
 *
 * @property int $id
 * @property int $item_id
 * @property string|null $t1
 * @property string|null $t2
 * @property string|null $t3
 * @property string|null $t4
 * @property string|null $t5
 * @property string|null $t6
 * @property string|null $t7
 * @property string|null $t8
 * @property string|null $t9
 * @property string|null $t10
 * @property int|null $i1
 * @property int|null $i2
 * @property int|null $i3
 * @property int|null $i4
 * @property int|null $i5
 * @property int|null $i6
 *
 * @property Image $i10
 * @property Image $i20
 * @property Image $i30
 * @property Image $i40
 * @property Image $i50
 * @property Image $i60
 * @property Item $item
 */
class ItemEn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_en';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id'], 'required'],
            [['item_id', 'i1', 'i2', 'i3', 'i4', 'i5', 'i6'], 'integer'],
            [['t1', 't2', 't3', 't4', 't5', 't6', 't7', 't8', 't9', 't10'], 'string'],
            [['item_id'], 'unique'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['i1'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['i1' => 'id']],
            [['i2'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['i2' => 'id']],
            [['i3'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['i3' => 'id']],
            [['i4'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['i4' => 'id']],
            [['i5'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['i5' => 'id']],
            [['i6'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['i6' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            't1' => 'T1',
            't2' => 'T2',
            't3' => 'T3',
            't4' => 'T4',
            't5' => 'T5',
            't6' => 'T6',
            't7' => 'T7',
            't8' => 'T8',
            't9' => 'T9',
            't10' => 't10',
            'i1' => 'I1',
            'i2' => 'I2',
            'i3' => 'I3',
            'i4' => 'I4',
            'i5' => 'I5',
            'i6' => 'I6',
        ];
    }

    /**
     * Gets query for [[I10]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getI10()
    {
        return $this->hasOne(Image::className(), ['id' => 'i1']);
    }

    /**
     * Gets query for [[I20]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getI20()
    {
        return $this->hasOne(Image::className(), ['id' => 'i2']);
    }

    /**
     * Gets query for [[I30]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getI30()
    {
        return $this->hasOne(Image::className(), ['id' => 'i3']);
    }

    /**
     * Gets query for [[I40]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getI40()
    {
        return $this->hasOne(Image::className(), ['id' => 'i4']);
    }

    /**
     * Gets query for [[I50]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getI50()
    {
        return $this->hasOne(Image::className(), ['id' => 'i5']);
    }

    /**
     * Gets query for [[I60]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getI60()
    {
        return $this->hasOne(Image::className(), ['id' => 'i6']);
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    public function fields()
    {
        $fields = array_merge(parent::fields(), ['i10', 'i20', 'i30', 'i40', 'i50', 'i60']);
        unset($fields['i1'], $fields['i2'], $fields['i3'], $fields['i4'], $fields['i5'], $fields['i6']);
        return $fields;
    }
}