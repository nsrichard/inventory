<?php

use yii\db\Migration;

class m250628_153230_seed_demo_data extends Migration
{
    public function safeUp()
    {
        // Categorías
        $this->batchInsert('category', ['name'], [
            ['Electronics'],
            ['Books'],
            ['Clothing'],
        ]);

        // Obtener IDs insertados
        $categories = (new \yii\db\Query())->from('category')->all();

        // Productos
        $this->batchInsert('product', ['name', 'description', 'price', 'stock', 'category_id'], [
            ['Smartphone', 'Android device with 128GB storage', 299.99, 50, $categories[0]['id'] ?? null],
            ['E-book Reader', 'Waterproof with backlight', 119.90, 80, $categories[0]['id'] ?? null],
            ['Novel', 'Mystery fiction bestseller', 19.99, 100, $categories[1]['id'] ?? null],
            ['T-Shirt', '100% cotton, unisex', 12.49, 200, $categories[2]['id'] ?? null],
        ]);
    }

    public function safeDown()
    {
        $this->delete('product');
        $this->delete('category');
    }
}
