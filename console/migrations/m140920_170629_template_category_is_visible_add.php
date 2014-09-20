<?php

use yii\db\Schema;
use yii\db\Migration;

class m140920_170629_template_category_is_visible_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%template_category}}', 'is_visible', Schema::TYPE_BOOLEAN . ' DEFAULT "0"');
    }

    public function down()
    {
        $this->dropColumn('{{%template_category}}', 'is_visible');
    }
}
