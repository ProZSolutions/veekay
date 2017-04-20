<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Customer".
 *
 * @property string $cust_ID
 * @property string $cust_Name
 * @property string $cust_Door_No
 * @property string $cust_Street_Name
 * @property string $cust_town
 * @property string $cust_country
 * @property string $cust_postcode
 * @property string $cust_band
 * @property string $cust_img
 * @property string $cust_mail
 * @property string $cust_no
 * @property string $cust_AltNo
 * @property int $is_Active
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cust_ID', 'cust_Name', 'cust_Door_No', 'cust_Street_Name', 'cust_town', 'cust_country', 'cust_postcode', 'cust_band', 'cust_mail', 'cust_no', 'cust_AltNo'], 'required'],
            [['is_Active'], 'integer'],
            [['cust_ID', 'cust_Name', 'cust_Door_No', 'cust_Street_Name', 'cust_town', 'cust_country', 'cust_postcode', 'cust_band', 'cust_img', 'cust_mail', 'cust_no', 'cust_AltNo'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cust_ID' => 'Customer  ID',
            'cust_Name' => 'Customer  Name',
            'cust_Door_No' => 'Customer  Door  No',
            'cust_Street_Name' => 'Customer  Street  Name',
            'cust_town' => 'Customer Town',
            'cust_country' => 'Customer Country',
            'cust_postcode' => 'Customer Postcode',
            'cust_band' => 'Customer Band',
            'cust_img' => 'Customer Img',
            'cust_mail' => 'Customer Mail',
            'cust_no' => 'Customer No',
            'cust_AltNo' => 'Customer  Alt No',
            'is_Active' => 'Is  Active',
        ];
    }
}
