<?php

use yii\db\Schema;
use yii\db\Migration;

class m141116_182413_template_section_create extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%template_section}}', [
            'id' => 'pk',
            'template_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'section_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey('fk_template_section_template', '{{%template_section}}', 'template_id', '{{%template}}', 'id', 'cascade');
        $this->addForeignKey('fk_template_section_section', '{{%template_section}}', 'section_id', '{{%section}}', 'id', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_template_section_template', '{{%template_section}}');
        $this->dropForeignKey('fk_template_section_section', '{{%template_section}}');

        $this->dropTable('{{%template_section}}');
    }
}
