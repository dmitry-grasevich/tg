<?php

use yii\db\Schema;
use yii\db\Migration;

class m141120_203146_section_control_default_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%section_control}}', 'default', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('{{%section_control}}', 'default');
    }
}
