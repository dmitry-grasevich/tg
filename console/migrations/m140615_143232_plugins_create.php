<?php

use yii\db\Schema;

class m140615_143232_plugins_create extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%plugin}}', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'directory' => Schema::TYPE_STRING . ' DEFAULT ""',
        ], $tableOptions);

        $this->createTable('{{%template_plugin}}', [
            'id' => 'pk',
            'template_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'plugin_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey('fk_template_plugin_template', '{{%template_plugin}}', 'template_id', '{{%template}}', 'id', 'cascade');
        $this->addForeignKey('fk_template_plugin_plugin', '{{%template_plugin}}', 'plugin_id', '{{%plugin}}', 'id', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_template_plugin_template', '{{%template_plugin}}');
        $this->dropForeignKey('fk_template_plugin_plugin', '{{%template_plugin}}');

        $this->dropTable('{{%template_plugin}}');
        $this->dropTable('{{%plugin}}');
    }
}
