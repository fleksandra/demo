<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 *
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название категории',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    public static function getCountCategory()
    {
        return static::find()->asArray()->count();
    }

    public static function getCategory()
    {
        return (new \yii\db\Query())
        ->select('title')
        ->from(static::tableName())
        ->indexBy('id')
        ->column();
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        
        $photo_del = Product::find()->select(['photo'])->where(['category_id' => $this->id])->asArray()->all();
        foreach($photo_del as $val) {
            $photo = Yii::getAlias('@webroot') .'/uploads/' .$val['photo'];   
            if(!empty($val['photo'])) {
                if(file_exists($photo)) {
                    unlink($photo);
                }
            }
        }

        return true;
    }
}
