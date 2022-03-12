<?php

namespace app\controllers\abstractions;

use app\models\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

abstract class RestController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $authenticatorWithoutBearer = $behaviors['authenticator'];
        $behaviors['authenticator'] = ['class' => HttpBearerAuth::class];
        $controllersWithoutBearer = ['auth', 'data', 'region']; //, 'product', 'image'
        if (in_array(Yii::$app->controller->id, $controllersWithoutBearer)) {
            $behaviors['authenticator'] = $authenticatorWithoutBearer;
        }

        // INSTEAD CORS FILTER. (MAY BE INSERTED TO web/index.php)
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, x-compress');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Request-Method: GET, PUT, PATCH, DELETE, HEAD, OPTIONS');



        // $behaviors['corsFilter'] = [
        //     'class' => Cors::class,
        //     // restrict access to
        //     'Origin' => ['http://localhost:4200'],
        //     // Allow only POST and PUT methods
        //     'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
        //     // Allow only headers 'X-Wsse'
        //     'Access-Control-Request-Headers' => ['X-Wsse'],
        //     // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
        //     'Access-Control-Allow-Credentials' => true,
        //     // Allow OPTIONS caching
        //     'Access-Control-Max-Age' => 3600,
        //     // Allow the X-Pagination-Current-Page header to be exposed to the browser.
        //     'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],


        //     // 'cors' => [
        //     //     'Origin' => '*'
        //     //         // 'http://localhost:4200',
        //     //         // 'http://node-store.injini.ru'
        //     //     ,
        //     //     // 'Access-Control-Allow-Origin' => '*',
        //     //     'Access-Control-Allow-Credentials' => true,
        //     //     'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
        //     //     'Access-Control-Allow-Headers' => ['Origin', 'Content-Type', 'Authorization', 'x-compress']
        //     // ],
        // ];

        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
    }

    protected function getUserId()
    {
        $token = Yii::$app->request->headers['Authorization'];
        if ($token && strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
            $user = User::findIdentityByAccessToken($token);
            return $user->id;
        }
        return;
    }
}
