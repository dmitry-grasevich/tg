<?php

use yii\db\Schema;

class m140528_183554_create_functions extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%functions}}', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'code' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->createTable('{{%template_functions}}', [
            'id' => 'pk',
            'template_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'functions_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->insert('{{%functions}}', [
            'id' => 1,
            'name' => 'Define Constants',
            'code' => "define('THEMEROOT', get_stylesheet_directory_url());
define('IMAGES', THEMEROOT . '/images');"
        ]);

        $this->insert('{{%template_functions}}', [
            'template_id' => 1,
            'functions_id' => 1,
        ]);

        $this->addForeignKey('fk_template_functions_template', '{{%template_functions}}', 'template_id', '{{%template}}', 'id', 'cascade');
        $this->addForeignKey('fk_template_functions_functions', '{{%template_functions}}', 'functions_id', '{{%functions}}', 'id', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_template_functions_template', '{{%template_functions}}');
        $this->dropForeignKey('fk_template_functions_functions', '{{%template_functions}}');

        $this->dropTable('{{%functions}}');
        $this->dropTable('{{%template_functions}}');
    }
}
