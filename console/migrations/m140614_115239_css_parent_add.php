<?php

use yii\db\Schema;

class m140614_115239_css_parent_add extends \yii\db\Migration
{
    public function up()
    {
        $this->addColumn('{{%css}}', 'parent_id', Schema::TYPE_INTEGER);
        $this->addForeignKey('fk_css_parent', '{{%css}}', 'parent_id', '{{%template}}', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_css_parent', '{{%css}}');
        $this->dropColumn('{{%css}}', 'parent_id');
    }
}
