<?php

use yii\db\Schema;

class m140609_170546_fonts_create extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%font}}', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'filename' => Schema::TYPE_STRING,
            'directory' => Schema::TYPE_STRING . ' DEFAULT ""',
        ], $tableOptions);

        $this->createTable('{{%template_font}}', [
            'id' => 'pk',
            'template_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'font_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey('fk_template_font_template', '{{%template_font}}', 'template_id', '{{%template}}', 'id', 'cascade');
        $this->addForeignKey('fk_template_font_font', '{{%template_font}}', 'font_id', '{{%font}}', 'id', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_template_font_template', '{{%template_font}}');
        $this->dropForeignKey('fk_template_font_font', '{{%template_font}}');

        $this->dropTable('{{%template_font}}');
        $this->dropTable('{{%font}}');
    }
}
