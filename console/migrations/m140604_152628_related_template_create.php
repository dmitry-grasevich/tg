<?php

use yii\db\Schema;

class m140604_152628_related_template_create extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%related_template}}', [
            'id' => 'pk',
            'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'child_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey('fk_related_template_parent', '{{%related_template}}', 'parent_id', '{{%template}}', 'id', 'cascade');
        $this->addForeignKey('fk_related_template_child', '{{%related_template}}', 'child_id', '{{%template}}', 'id', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_related_template_parent', '{{%related_template}}');
        $this->dropForeignKey('fk_related_template_child', '{{%related_template}}');

        $this->dropTable('{{%related_template}}');
    }
}
