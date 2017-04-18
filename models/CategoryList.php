<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_list".
 *
 * @property string $category_id
 * @property string $category_name
 *
 * @property ProductList[] $productLists
 */
class CategoryList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'category_name'], 'required'],
            [['category_id'],'unique'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductLists()
    {
        return $this->hasMany(ProductList::className(), ['category_id' => 'category_id']);
    }
}
