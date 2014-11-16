<?php

use yii\db\Schema;
use yii\db\Migration;

class m141116_121814_section_create extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%section}}', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'code' => Schema::TYPE_TEXT . ' DEFAULT ""',
        ], $tableOptions);

        $this->createTable('{{%section_control}}', [
            'id' => 'pk',
            'section_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'control_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey('fk_section_control_section', '{{%section_control}}', 'section_id', '{{%section}}', 'id', 'cascade');
        $this->addForeignKey('fk_section_control_control', '{{%section_control}}', 'control_id', '{{%control}}', 'id', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_section_control_section', '{{%section_control}}');
        $this->dropForeignKey('fk_section_control_control', '{{%section_control}}');

        $this->dropTable('{{%section_control}}');
        $this->dropTable('{{%section}}');
    }
}
