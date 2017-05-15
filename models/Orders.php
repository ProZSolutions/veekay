<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property string $sales_RefID
 * @property string $cust_ID
 * @property string $products
 * @property double $total amount
 * @property string $order_ID
 *
 * @property Customer $cust
 * @property SalesRef $salesRef
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sales_RefID', 'cust_ID', 'products', 'total_amount'], 'required'],
            [['total_amount'], 'number'],
            [['sales_RefID', 'cust_ID', 'order_ID'], 'string', 'max' => 25],
            [['products'], 'string', 'max' => 500],
            [['cust_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['cust_ID' => 'cust_ID']],
            [['sales_RefID'], 'exist', 'skipOnError' => true, 'targetClass' => SalesRef::className(), 'targetAttribute' => ['sales_RefID' => 'sales_RefID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sales_RefID' => 'Sales  Ref ID',
            'cust_ID' => 'Cust  ID',
            'products' => 'Products',
            'total_amount' => 'Total Amount',
            'order_ID' => 'Order  ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCust()
    {
        return $this->hasOne(Customer::className(), ['cust_ID' => 'cust_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesRef()
    {
        return $this->hasOne(SalesRef::className(), ['sales_RefID' => 'sales_RefID']);
    }

    public function contact($email, $data)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo('vadivelan.proz@gmail.com')
                ->setFrom(['support@pro-z.in'])
                ->setSubject('Regarding Test Mail')
                ->setTextBody('Hello world')
                ->attach($data)
                ->send();
            return true;
        }
        return false;
    }
}
