<?php

use yii\db\Schema;
use yii\db\Migration;

class m141116_113555_control_create extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%control}}', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' DEFAULT ""',
            'code' => Schema::TYPE_TEXT . ' DEFAULT ""',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%control}}');
    }
}
