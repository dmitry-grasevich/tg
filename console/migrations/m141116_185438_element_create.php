<?php

use yii\db\Schema;
use yii\db\Migration;

class m141116_185438_element_create extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%element}}', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_STRING . ' NOT NULL',
            'section_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'priority' => Schema::TYPE_INTEGER. ' DEFAULT "0"',
            'css_selector' => Schema::TYPE_STRING . ' DEFAULT ""',
        ], $tableOptions);

        $this->createTable('{{%template_element}}', [
            'id' => 'pk',
            'template_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'element_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey('fk_template_element_template', '{{%template_element}}', 'template_id', '{{%template}}', 'id', 'cascade');
        $this->addForeignKey('fk_template_element_element', '{{%template_element}}', 'element_id', '{{%element}}', 'id', 'cascade');

        $this->dropForeignKey('fk_template_section_template', '{{%template_section}}');
        $this->dropForeignKey('fk_template_section_section', '{{%template_section}}');

        $this->dropTable('{{%template_section}}');
    }

    public function down()
    {
        $this->dropForeignKey('fk_template_element_template', '{{%template_element}}');
        $this->dropForeignKey('fk_template_element_element', '{{%template_element}}');

        $this->dropTable('{{%template_element}}');
        $this->dropTable('{{%element}}');

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%template_section}}', [
            'id' => 'pk',
            'template_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'section_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'priority' => Schema::TYPE_INTEGER . ' DEFAULT "0"',
            'css_selector' => Schema::TYPE_STRING . ' DEFAULT ""',
        ], $tableOptions);

        $this->addForeignKey('fk_template_section_template', '{{%template_section}}', 'template_id', '{{%template}}', 'id', 'cascade');
        $this->addForeignKey('fk_template_section_section', '{{%template_section}}', 'section_id', '{{%section}}', 'id', 'cascade');
    }
}
