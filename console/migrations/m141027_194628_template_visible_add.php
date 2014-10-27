<?php

use yii\db\Schema;
use yii\db\Migration;

class m141027_194628_template_visible_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%template}}', 'is_visible', Schema::TYPE_BOOLEAN . ' DEFAULT "0"');
    }

    public function down()
    {
        $this->dropColumn('{{%template}}', 'is_visible');
    }
}
