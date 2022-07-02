<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $timestamp
 * @property int $status_id
 * @property float $sum_price
 * @property int $count
 *
 * @property CompositionOrder[] $compositionOrders
 * @property Status $status
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    const SCENARIO_REFUSAL = 'refusal';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status_id', 'sum_price', 'count'], 'required'],
            [['user_id', 'status_id', 'count'], 'integer'],
            ['refusal', 'string'],
            ['refusal', 'required', 'on' => self::SCENARIO_REFUSAL],
            [['timestamp'], 'safe'],
            [['sum_price'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер заказа',
            'user_id' => 'User ID',
            'timestamp' => 'Дата совершения заказа',
            'status_id' => 'Статус',
            'sum_price' => 'Сумма, руб.',
            'count' => 'Количество товара, шт.',
            'refusal' => 'Причина отказа',
        ];
    }

    /**
     * Gets query for [[CompositionOrders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompositionOrders()
    {
        return $this->hasMany(CompositionOrder::className(), ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function orderCreate() {
        $this->user_id = Yii::$app->user->id;
        $this->status_id = Status::getStatusIdNew('Новый');
        $res = Cart::getCartInfo();
        $this->sum_price = $res['sum'];
        $this->count = $res['count'];
        return $this->save();
    }
}
