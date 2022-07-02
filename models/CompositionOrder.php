<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "composition_order".
 *
 * @property int $id
 * @property int $product_id
 * @property int $count
 * @property int $order_id
 * @property float $price
 * @property string $title_product
 *
 * @property Order $order
 */
class CompositionOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'composition_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'count', 'order_id', 'price', 'title_product'], 'required'],
            [['product_id', 'count', 'order_id'], 'integer'],
            [['price'], 'number'],
            [['title_product'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'count' => 'Count',
            'order_id' => 'Order ID',
            'price' => 'Price',
            'title_product' => 'Title Product',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public static function compositionOrderCreate($order_id) {
        $cart = Yii::$app->session->get('cart');
        foreach ($cart['products'] as $val) {
            $product = Product::findOne($val['id']);
            $order_product = new CompositionOrder();
            $order_product->order_id = $order_id;
            $order_product->product_id = $val['id'];
            $order_product->price = $val['price'];
            $order_product->title_product = $val['title'];
            $order_product->count = $val['count'];
            $product->count -= $val['count'];
            $order_product->save();
            $product->save();
        }
        Yii::$app->session->set('cart', []);
        return true;
    }

    public static function getProductOrder($id)
    {
        return (new \yii\db\Query())
        ->select(['composition_order.id', 'composition_order.product_id', 'composition_order.count', 'product.title', 'composition_order.price', 'product.photo'])
        ->from(static::tableName())
        ->where(['order_id' => $id])
        ->innerJoin(Product::tableName(), static::tableName() . '.product_id = ' . Product::tableName() . '.id')
        ->indexBy('id')
        ->all();
    }
}
