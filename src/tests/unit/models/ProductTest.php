<?php

namespace tests\unit\models;

use app\models\Product;
use Codeception\Test\Unit;

class ProductTest extends Unit
{
    public function testFailsWithoutRequiredFields()
    {
        $product = new Product();
        $this->assertFalse($product->validate());

        $errors = $product->getErrors();
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('price', $errors);
    }

    public function testPassesWithValidData()
    {
        $product = new Product([
            'name' => 'Teclado mecánico',
            'price' => 79.99,
            'stock' => 20,
        ]);

        $this->assertTrue($product->validate());
    }

    public function testProductCategoryRelation()
    {
        $product = \app\models\Product::find()->with('category')->one();

        if ($product === null) {
            $this->markTestSkipped('No hay productos en la base de datos.');
        } else {
            $this->assertNotNull($product->category, 'El producto no tiene una categoría relacionada.');
            $this->assertInstanceOf(\app\models\Category::class, $product->category);
        }
    }

}
