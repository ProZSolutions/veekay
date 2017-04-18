<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property string $cust_id
 * @property string $cust_name
 * @property string $cust_addr
 * @property int $cust_no
 * @property int $cust_alt_no
 * @property string $cust_band
 * @property string $cust_image
 * @property string $cust_mail
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cust_id', 'cust_name', 'cust_addr', 'cust_no', 'cust_alt_no', 'cust_band', 'cust_mail'], 'required'],
                 [['cust_id'],'unique'],
            [['cust_no', 'cust_alt_no'], 'integer'],
            [['cust_id'], 'string'],
            [['cust_name', 'cust_band'], 'string'],
            [['cust_addr', 'cust_image'], 'string'],
            [['cust_mail'], 'email'],
        ];
    }
     /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cust_id' => 'cust ID',
            'cust_name' => 'cust Name',
            'cust_addr' => 'cust Addr',
            'cust_no' => 'cust No',
            'cust_alt_no' => 'cust AltNo',
            'cust_band' => 'cust Band',
            'cust_image' => 'cust Image',
            'cust_mail' => ' Mail Id',
        ];
    }
}
