<?php

namespace app\models;

use Yii;

class UploadFile extends Product
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['imageFile', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'bmp'], 'skipOnEmpty' => false, 'maxSize' => 1240 * 1240 * 10, 'on' => self::SCENARIO_CREATE],
            ['imageFile', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'bmp'], 'skipOnEmpty' => true, 'maxSize' => 1240 * 1240 * 10, 'on' => self::SCENARIO_UPDATE],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'imageFile' => 'Фото товара'
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $nameFile = Yii::getAlias('@webroot') . '/uploads/' . Yii::$app->user->identity->login . time() . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($nameFile);
            return true;
        } else {
            return false;
        }
    }
}
