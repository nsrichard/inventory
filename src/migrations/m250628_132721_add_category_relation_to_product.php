<?php

use yii\db\Migration;

class m250628_132721_add_category_relation_to_product extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'category_id', $this->integer());

        $this->addForeignKey(
            'fk_product_category',
            '{{%product}}',
            'category_id',
            '{{%category}}',
            'id',
            'SET NULL',     // cuando se elimina una categoría, el campo queda nulo
            'CASCADE'       // si se actualiza el ID de la categoría, se actualiza en product
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_product_category', '{{%product}}');
        $this->dropColumn('{{%product}}', 'category_id');
    }
}
