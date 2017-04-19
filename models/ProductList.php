<?php

namespace app\models;

use Yii;

use yii\web\UploadedFile;

/**
 * This is the model class for table "product_list".
 *
 * @property string $category_id
 * @property int $product_count
 * @property string $product_desc
 * @property string $product_id
 * @property string $product_image
 * @property string $product_name
 * @property int $product_price
 *
 * @property CategoryList $category
 */
class ProductList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
 
    public static function tableName()
    {
        return 'product_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id','product_count', 'product_desc', 'product_id', 'product_name', 'product_price'], 'required'],
            [['product_id'],'unique'],
            [['product_image'],'file'],
            [['product_count'], 'integer'],
            [['product_price'], 'double']
            [['category_id', 'product_id', 'product_name'], 'string', 'max' => 50],
            [['product_desc'], 'string', 'max' => 100],
            
            [['category_id'],'exist', 'skipOnError' => true, 'targetClass' => CategoryList::className(), 'targetAttribute' => ['category_id' => 'category_id']],
        ];
    }
    //  public function upload()
    // {
    //     if ($this->validate()) {
    //         $this->product_image->saveAs('uploads/' . $this->product_image->baseName . '.' . $this->product_image->extension);
          
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'product_count' => 'Product Count',
            'product_desc' => 'Product Desc',
            'product_id' => 'Product ID',
            'product_image' => 'Product Image',
            'product_name' => 'Product Name',
            'product_price' => 'Product Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CategoryList::className(), ['category_id' => 'category_id']);
    }
}
