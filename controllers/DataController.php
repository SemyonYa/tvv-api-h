<?php

namespace app\controllers;

use app\controllers\abstractions\RestController;
use app\models\Item;
use app\models\Place;
use app\models\Product;
use app\models\ProductCategory;
use app\models\ProductSubject;
use app\models\Project;
use app\models\ProjectType;
use app\models\Region;

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

    public function actionRegions()
    {
        return Region::find()->orderBy('name ASC')->all();
    }

    public function actionRegion($regionId)
    {
        return Region::findOne($regionId);
    }

    public function actionPlaces($regionId)
    {
        return Place::find()
            ->where(['region_id' => $regionId])
            ->all();
    }

    public function actionPlace($placeId)
    {
        return Place::findOne($placeId);
    }

    public function actionProjects($placeId)
    {
        return Project::find()->where(['place_id' => $placeId])->all();
    }

    public function actionProject($projectId)
    {
        return Project::findOne($projectId);
    }

    public function actionProjectTypes()
    {
        return ProjectType::find()->all();
    }
}
