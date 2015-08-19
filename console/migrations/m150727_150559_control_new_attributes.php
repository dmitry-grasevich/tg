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

        $this->addColumn('{{%control}}', 'family', $this->string()->notNull());
        $this->addColumn('{{%control}}', 'type', $this->string()->notNull()->unique());
        $this->addColumn('{{%control}}', 'class', $this->string()->notNull());
        $this->addColumn('{{%control}}', 'params', $this->text());

        $this->createTable('{{%control_image}}', [
            'id' => 'pk',
            'control_id' => $this->integer()->notNull(),
            'image_id' => $this->integer()->notNull(),
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
