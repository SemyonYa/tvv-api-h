<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * Identity interface implementation
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $login
 * @property string $role
 * @property string $birth
 * @property string|null $password_hash
 * @property string|null $auth_token
 * @property int $activated
 */
class UserIdentity extends \yii\db\ActiveRecord implements IdentityInterface
{

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_token === $authKey;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_token' => $token]);
    }

    public function updateToken()
    {
        $this->auth_token = Yii::$app->security->generateRandomString(128);
        $this->save();
        return $this->auth_token;
    }
}
