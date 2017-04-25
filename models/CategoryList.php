<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_list".
 *
 * @property string $category_id
 * @property string $category_name
 * @property int $is_Active
 *
 * @property Product[] $products
 * @property ProductList[] $productLists
 */
class CategoryList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'category_name'], 'required'],
            [['is_Active'], 'integer'],
            [['category_id', 'category_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'category_name' => 'Category Name',
            'is_Active' => 'Is  Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['Category_ID' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   
}
