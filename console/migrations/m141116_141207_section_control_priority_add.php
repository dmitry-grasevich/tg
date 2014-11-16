<?php

use yii\db\Schema;
use yii\db\Migration;

class m141116_141207_section_control_priority_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%section_control}}', 'priority', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('{{%section_control}}', 'priority');
    }
}
