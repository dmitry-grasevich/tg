<?php

use yii\db\Schema;

class m140614_112912_functions_parent_add extends \yii\db\Migration
{
    public function up()
    {
        $this->addColumn('{{%functions}}', 'parent_id', Schema::TYPE_INTEGER);
        $this->addForeignKey('fk_functions_parent', '{{%functions}}', 'parent_id', '{{%template}}', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_functions_parent', '{{%functions}}');
        $this->dropColumn('{{%functions}}', 'parent_id');
    }
}
