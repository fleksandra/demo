<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $title
 *
 * @property Order[] $orders
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
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
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['status_id' => 'id']);
    }

    public static function getStatusIdNew($status)
    {
        return static::findOne(['title' => $status])->id;
    }

    public static function getStatus()
    {
        return (new \yii\db\Query())
        ->select('title')
        ->from(static::tableName())
        ->indexBy('id')
        ->column();
    }

    public static function getStatusOld()
    {
        return (new \yii\db\Query())
        ->select('title')
        ->from(static::tableName())
        ->where(['<>', 'title', 'Новый'])
        ->column();
    }
}
