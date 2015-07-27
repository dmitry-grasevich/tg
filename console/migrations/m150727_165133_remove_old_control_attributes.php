<?php

use yii\db\Schema;
use yii\db\Migration;

class m150727_165133_remove_old_control_attributes extends Migration
{
    public function up()
    {
        $this->addColumn('{{%control}}', 'img', Schema::string());
        $this->addColumn('{{%control}}', 'css', Schema::text());
        $this->dropColumn('{{%control}}', 'code');
        $this->dropColumn('{{%control}}', 'styles_code');
        $this->dropColumn('{{%control}}', 'mods_code');

        $this->dropForeignKey('fk_control_image_control', '{{%control_image}}');
        $this->dropForeignKey('fk_control_image_image', '{{%control_image}}');

        $this->dropTable('{{%control_image}}');
    }

    public function down()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->dropColumn('{{%control}}', 'img');
        $this->dropColumn('{{%control}}', 'css');
        $this->addColumn('{{%control}}', 'code', Schema::text());
        $this->addColumn('{{%control}}', 'styles_code', Schema::text());
        $this->addColumn('{{%control}}', 'mods_code', Schema::text());

        $this->createTable('{{%control_image}}', [
            'id' => 'pk',
            'control_id' => Schema::integer()->notNull(),
            'image_id' => Schema::integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_control_image_control', '{{%control_image}}', 'control_id', '{{%control}}', 'id', 'cascade');
        $this->addForeignKey('fk_control_image_image', '{{%control_image}}', 'image_id', '{{%image}}', 'id', 'cascade');
    }
}
