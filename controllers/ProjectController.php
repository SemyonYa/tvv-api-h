<?php

namespace app\controllers;

use app\controllers\abstractions\RestController;
use app\models\ProjectType;

class ProjectController extends RestController
{
    public $modelClass = 'app\models\Project';
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete']);
        // unset($actions['create'], $actions['update'], $actions['index']);

        return $actions;
    }

    public function actionTypes()
    {
        return ProjectType::find()->all();
    }
}
