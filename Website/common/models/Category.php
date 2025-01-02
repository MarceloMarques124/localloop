<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Item[] $items
 * @property SubCategory[] $subCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Category name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['sub_category_id' => 'id']);
    }

    /**
     * Gets query for [[SubCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategories()
    {
        return $this->hasMany(SubCategory::class, ['category_id' => 'id']);
    }
}
