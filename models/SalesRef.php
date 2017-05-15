<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_ref".
 *
 * @property string $sales_RefID
 * @property string $cust_List
 * @property string $sales_Name
 * @property string $sales_Pswd
 * @property string $sales_Email
 * @property int $sales_No
 * @property string $sales_RefImg
 * @property string $last_login
 * @property string $is_time
 */
class SalesRef extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sales_ref';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sales_RefID', 'cust_List', 'sales_Name', 'sales_Pswd', 'sales_Email', 'sales_No'], 'required'],
            [['sales_No'], 'integer'],
            [['last_login', 'is_time'], 'safe'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sales_RefID' => 'Sales  Ref ID',
            'cust_List' => 'Cust  List',
            'sales_Name' => 'Sales  Name',
            'sales_Pswd' => 'Sales  Pswd',
            'sales_Email' => 'Sales  Email',
            'sales_No' => 'Sales  No',
            'sales_RefImg' => 'Sales  Ref Img',
            'last_login' => 'Last Login',
            'is_time' => 'Is Time',
        ];
    }
}
