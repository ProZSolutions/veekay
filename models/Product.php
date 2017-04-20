<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Product".
 *
 * @property string $Category_ID
 * @property string $product_Id
 * @property int $product_Count
 * @property string $product_Desc
 * @property string $product_Name
 * @property double $product_Price
 * @property string $product_Image
 * @property string $product_Band
 * @property int $is_Active
 *
 * @property CategoryList $category
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Category_ID', 'product_Id', 'product_Count', 'product_Desc', 'product_Name', 'product_Price','product_Band',], 'required'],
            [['product_Count', 'is_Active'], 'integer'],
            [['product_Price'], 'number'],
            [['Category_ID', 'product_Id'], 'string', 'max' => 25],
            [['product_Desc'], 'string', 'max' => 100],
            [['product_Name', 'product_Image'], 'string', 'max' => 50],
            [['product_Band'], 'string', 'max' => 30],
            [['Category_ID'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryList::className(), 'targetAttribute' => ['Category_ID' => 'category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Category_ID' => 'Category  ID',
            'product_Id' => 'Product  ID',
            'product_Count' => 'Product  Count',
            'product_Desc' => 'Product  Desc',
            'product_Name' => 'Product  Name',
            'product_Price' => 'Product  Price',
            'product_Image' => 'Product  Image',
            'product_Band' => 'Product  Band',
            'is_Active' => 'Is  Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CategoryList::className(), ['category_id' => 'Category_ID']);
    }
}
