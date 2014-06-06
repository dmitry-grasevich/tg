<?php

use yii\db\Schema;

class m140606_084648_image_create extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%image}}', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'filename' => Schema::TYPE_STRING,
            'directory' => Schema::TYPE_STRING . ' DEFAULT ""',
        ], $tableOptions);

        $this->createTable('{{%template_image}}', [
            'id' => 'pk',
            'template_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'image_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey('fk_template_image_template', '{{%template_image}}', 'template_id', '{{%template}}', 'id', 'cascade');
        $this->addForeignKey('fk_template_image_image', '{{%template_image}}', 'image_id', '{{%image}}', 'id', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_template_image_template', '{{%template_image}}');
        $this->dropForeignKey('fk_template_image_image', '{{%template_image}}');

        $this->dropTable('{{%template_image}}');
        $this->dropTable('{{%image}}');
    }
}
