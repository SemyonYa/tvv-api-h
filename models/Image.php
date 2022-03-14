<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

use Imagine\Image\Box;
use yii\imagine\Image as ImagineImage;


/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $name
 * @property int $deleted
 */
class Image extends \yii\db\ActiveRecord
{

    public function __construct($name = '')
    {
        $this->name = $name;
    }

    private $allowable_extetions = [
        'jpg',
        'png',
        // 'svg'
    ];

    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['deleted'], 'integer'],
            [['name'], 'string', 'max' => 100],
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
        ];
    }

    public function resizeAndSave()
    {
        $path = Yii::getAlias('@webroot/' . Yii::$app->params['images_dir'] . '/');
        $image = ImagineImage::getImagine()->open($path . $this->name);
        $m_data = $image->metadata();
        $w = $m_data['computed.Width'];
        $h = $m_data['computed.Height'];
        $s = ($w > $h) ? $w : $h;
        if ($s > 1920) {
            $image->thumbnail(new Box(1920, 1920))->save($path . $this->name, ['quality' => 100]);
        }
        $image->thumbnail(new Box(960, 960))->save($path . '_' . $this->name, ['quality' => 50]);
        $image->thumbnail(new Box(360, 360))->save($path . '__' . $this->name, ['quality' => 50]);
    }

    public function getThumb()
    {
        return Yii::$app->request->hostInfo . '/images/__' . $this->name;
    }

    public function getMedium()
    {
        return Yii::$app->request->hostInfo . '/images/_' . $this->name;
    }

    public function getLarge()
    {
        return Yii::$app->request->hostInfo . '/images/' . $this->name;
    }

    public function fields()
    {
        // $fields = parent::fields();
        $fields = array_merge(parent::fields(), ['thumb', 'medium', 'large']);
        unset($fields['name'], $fields['deleted']);
        return $fields;
    }


    // public function upload($name, $tmp_name)
    // {
    //     $expl_name = explode('.', $name);
    //     $extention = strtolower(array_pop($expl_name));
    //     if (!in_array($extention, $this->allowable_extetions)) {
    //         return false;
    //     }
    //     $img_name = Yii::$app->security->generateRandomString(20) . '.' . $extention;
    //     $img_temp_name = $tmp_name;
    //     $path = Yii::getAlias('@webroot/images/');
    //     FileHelper::createDirectory($path);
    //     rename($img_temp_name, $path . $img_name);
    //     $image = ImagineImage::getImagine()->open($path . $img_name);
    //     $m_data = $image->metadata();
    //     $w = $m_data['computed.Width'];
    //     $h = $m_data['computed.Height'];
    //     $s = ($w > $h) ? $h : $w;
    //     if ($s > 800) {
    //         $image->thumbnail(new Box(800, 800))->save($path . $img_name, ['quality' => 50]);
    //     }
    //     $image->thumbnail(new Box(300, 300))->save($path . '____' . $img_name, ['quality' => 50]);
    //     $this->name = $img_name;
    //     // $my_img = new Image();
    //     // $my_img->name = $img_name;
    //     // $my_img->save();
    //     // }
    // }
}
