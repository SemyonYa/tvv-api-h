<?php

namespace app\controllers;

use app\controllers\abstractions\RestController;
use Yii;
use app\models\LoginView;
use app\models\User;
use Throwable;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class AuthController extends RestController
{

    public $modelClass = 'app\models\User';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['index'], $actions['view']);
        return $actions;
    }

    /** Login action */
    public function actionCreate()
    {
        $request = Yii::$app->request;

        $login = $request->post('login');
        $password = $request->post('password');

        $login_view = new LoginView($login, $password);
        if ($login_view->validate()) {
            $token = $login_view->login();
            if ($token) {
                return [
                    'token' => $token,
                ];
            }
        }
        throw new BadRequestHttpException('Неверные имя пользователя / пароль');
    }

    /** Logout action */
    public function actionDelete()
    {
        try {
            $token = Yii::$app->request->headers['Authorization'];
            if ($token && strpos($token, 'Bearer ') === 0) {
                $token = substr($token, 7);
                if ($user = User::findOne(['auth_token' => $token])) {
                    // return $user;
                    $user->auth_token = null;
                    $user->save();
                    return;
                }
            }
            throw new UnauthorizedHttpException();
        } catch (Throwable $th) {
            throw new UnauthorizedHttpException();
        }
    }
}
