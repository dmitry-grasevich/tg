<?php

use yii\db\Schema;
use yii\db\Migration;

class m150801_174811_section_priority_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%section}}', 'priority', Schema::integer());
    }

    public function down()
    {
        $this->dropColumn('{{%section}}', 'priority');
    }
}
