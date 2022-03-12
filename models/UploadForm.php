<?php

namespace app\models;

use ErrorException;
use Throwable;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\ServerErrorHttpException;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $files;

    public function rules()
    {
        return [
            // [['files'], 'safe'],
            [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg']
        ];
    }

    public function upload()
    {
        try {
            $names = [];
            if (!$this->hasErrors()) {
                $path = Yii::getAlias('@webroot/' . Yii::$app->params['images_dir'] . '/');
                FileHelper::createDirectory($path);
                foreach ($this->files as $file) {
                    $extension = substr($file->name, strrpos($file->name, '.'));
                    $name = Yii::$app->security->generateRandomString(20) . $extension;
                    $file->saveAs($path . $name);
                    $names[] = $name;
                }
                return $names;
            } else {
                return false;
            }
        } catch (Throwable $th) {
            throw $th;
            // throw new ServerErrorHttpException();
        }
    }
}
