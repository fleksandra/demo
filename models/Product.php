<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property string $photo
 * @property float $price
 * @property string $country
 * @property string $year
 * @property string $model
 * @property int $category_id
 * @property int $count
 *
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'photo', 'price', 'country', 'year', 'model', 'category_id', 'count'], 'required'],
            [['price'], 'number'],
            [['year'], 'safe'],
            [['category_id', 'count'], 'integer'],
            [['title', 'photo', 'country', 'model'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'photo' => 'Фото товара',
            'price' => 'Цена (руб)',
            'country' => 'Страна производителя',
            'year' => 'Год выпуска',
            'model' => 'Модель',
            'category_id' => 'Категория',
            'count' => 'Количество',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public static function getProduct()
    {
        return (new \yii\db\Query())
        ->select('*')
        ->from(static::tableName())
        ->where(['<>', 'count', 0])
        ->indexBy('id')
        ->orderBy(['id' => SORT_DESC])
        ->all();
    }

    public static function getProductNew()
    {
        return (new \yii\db\Query())
        ->select('*')
        ->from(static::tableName())
        ->orderBy(['id' => SORT_DESC])
        ->limit(5)
        ->all();
    }
}
