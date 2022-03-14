<?php

namespace app\models;

use Yii;
use yii\helpers\Inflector;

/**
 * This is the model class for table "place".
 *
 * @property int $id
 * @property string $name
 * @property string|null $brief
 * @property string $description
 * @property int $region_id
 * @property int $image_id
 *
 * @property Image $image
 * @property Project[] $projects
 * @property Region $region
 */
class Place extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'place';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'region_id', 'image_id'], 'required'],
            [['description'], 'string'],
            [['region_id', 'image_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['brief'], 'string', 'max' => 200],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
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
            'brief' => 'Brief',
            'description' => 'Description',
            'region_id' => 'Region ID',
            'image_id' => 'Image ID',
        ];
    }

    /**
     * Gets query for [[Image]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * Gets query for [[Projects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['place_id' => 'id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    public function fields()
    {
        $fields = array_merge(
            parent::fields(),
            [
                'regionName' => function ($model) {
                    return $model->region->name;
                },
                'image',
            ]
        );
        unset($fields['imageId']);
        $formattedFields = [];
        foreach ($fields as $key => $name) {
            $formattedFields[Inflector::variablize($key)] = $name;
        }

        return $formattedFields;
    }
}
