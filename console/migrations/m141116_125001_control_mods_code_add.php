<?php

use yii\db\Schema;
use yii\db\Migration;

class m141116_125001_control_mods_code_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%control}}', 'mods_code', Schema::TYPE_TEXT);
    }

    public function down()
    {
        $this->dropColumn('{{%control}}', 'mods_code');
    }
}
