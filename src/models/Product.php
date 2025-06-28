<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property int|null $stock
 * @property string $created_at
 * @property int|null $category_id
 *
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    public function rules()
    {
        return [
            [['name', 'price'], 'required', 'message' => 'El campo {attribute} es obligatorio.'],
            ['name', 'string', 'max' => 255, 'tooLong' => 'El nombre no puede superar los 255 caracteres.'],
            ['price', 'number', 'min' => 0, 'tooSmall' => 'El precio debe ser igual o mayor a 0.'],
            ['stock', 'integer', 'min' => 0, 'tooSmall' => 'El stock no puede ser negativo.'],
            ['category_id', 'exist',
                'targetClass' => Category::class,
                'targetAttribute' => ['category_id' => 'id'],
                'message' => 'La categoría seleccionada no es válida.'
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'stock' => 'Stock',
            'created_at' => 'Created At',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function extraFields()
    {
        return ['category'];
    }

    public function fields()
    {
        return array_merge(parent::fields(), ['category']);
    }

}
