<?php

use yii\db\Schema;
use yii\db\Migration;

class m150727_150559_control_new_attributes extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->addColumn('{{%control}}', 'family', Schema::string()->notNull());
        $this->addColumn('{{%control}}', 'type', Schema::string()->notNull()->unique());
        $this->addColumn('{{%control}}', 'class', Schema::string()->notNull());
        $this->addColumn('{{%control}}', 'params', Schema::text());

        $this->createTable('{{%control_image}}', [
            'id' => 'pk',
            'control_id' => Schema::integer()->notNull(),
            'image_id' => Schema::integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_control_image_control', '{{%control_image}}', 'control_id', '{{%control}}', 'id', 'cascade');
        $this->addForeignKey('fk_control_image_image', '{{%control_image}}', 'image_id', '{{%image}}', 'id', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_control_image_control', '{{%control_image}}');
        $this->dropForeignKey('fk_control_image_image', '{{%control_image}}');

        $this->dropTable('{{%control_image}}');
        $this->dropColumn('{{%control}}', 'family');
        $this->dropColumn('{{%control}}', 'type');
        $this->dropColumn('{{%control}}', 'class');
        $this->dropColumn('{{%control}}', 'params');
    }
}
