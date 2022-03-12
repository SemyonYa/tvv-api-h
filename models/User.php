<?php

namespace app\models;

/**
 * This is the model class for table "user".
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
class User extends UserIdentity
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'login', 'birth', 'activated'], 'required'],
            [['role', 'password_hash'], 'string'],
            [['birth'], 'safe'],
            [['activated'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['login'], 'string', 'max' => 20],
            [['auth_token'], 'string', 'max' => 200],
            [['login'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'login' => 'Login',
            'role' => 'Role',
            'birth' => 'Birth',
            'password_hash' => 'Password Hash',
            'auth_token' => 'Auth Token',
            'activated' => 'Activated',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        // удаляем небезопасные поля
        unset($fields['auth_token'], $fields['password_hash']);

        return $fields;
    }
}
