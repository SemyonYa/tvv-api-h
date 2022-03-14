<?php

namespace app\models;

use Yii;
use yii\helpers\Inflector;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property string|null $brief
 * @property string $description
 * @property int $place_id
 * @property int $project_type_id
 * @property string $people
 * @property string $calendar
 * @property int $costs
 *
 * @property Place $place
 * @property ProjectImage[] $projectImages
 * @property ProjectType $projectType
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'place_id', 'project_type_id', 'people', 'calendar', 'costs'], 'required'],
            [['description'], 'string'],
            [['place_id', 'project_type_id', 'costs'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['brief'], 'string', 'max' => 300],
            [['people', 'calendar'], 'string', 'max' => 100],
            [['project_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectType::className(), 'targetAttribute' => ['project_type_id' => 'id']],
            [['place_id'], 'exist', 'skipOnError' => true, 'targetClass' => Place::className(), 'targetAttribute' => ['place_id' => 'id']],
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
            'place_id' => 'Place ID',
            'project_type_id' => 'Project Type ID',
            'people' => 'People',
            'calendar' => 'Calendar',
            'costs' => 'Costs',
        ];
    }

    /**
     * Gets query for [[Place]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(Place::className(), ['id' => 'place_id']);
    }

    /**
     * Gets query for [[ProjectImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectImages()
    {
        return $this->hasMany(ProjectImage::className(), ['project_id' => 'id']);
    }

    /**
     * Gets query for [[ProjectType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectType()
    {
        return $this->hasOne(ProjectType::className(), ['id' => 'project_type_id']);
    }

    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id' => 'image_id'])->viaTable('project_image', ['project_id' => 'id']);
    }

    public function fields()
    {
        $fields = array_merge(
            parent::fields(),
            [
                'projectTypeName' => function ($model) {
                    return $model->projectType->name;
                },
                'placeName' => function ($model) {
                    return $model->place->name;
                },
                'regionId' => function ($model) {
                    return $model->place->region_id;
                },
                'regionName' => function ($model) {
                    return $model->place->region->name;
                },
                'images',
                'descriptionParagraphs' => function ($model) {
                    return preg_split('/$\R?^:/m', $model->description);
                    // return explode('\n', $model->description);
                }
            ]
        );
        $formattedFields = [];
        foreach ($fields as $key => $name) {
            $formattedFields[Inflector::variablize($key)] = $name;
        }

        return $formattedFields;
    }
}
