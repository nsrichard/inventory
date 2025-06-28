<?php

namespace tests\unit\models;

use app\models\Category;
use Codeception\Test\Unit;

class CategoryTest extends Unit
{
    public function testFailsWithoutName()
    {
        $category = new Category();
        $this->assertFalse($category->validate());
        $this->assertArrayHasKey('name', $category->getErrors());
    }

    public function testFailsWithTooLongName()
    {
        $category = new Category([
            'name' => str_repeat('a', 101),
        ]);
        $this->assertFalse($category->validate());
        $this->assertArrayHasKey('name', $category->getErrors());
    }

    public function testValidCategory()
    {
        $category = new Category([
            'name' => 'Libros',
        ]);
        $this->assertTrue($category->validate());
    }
}
