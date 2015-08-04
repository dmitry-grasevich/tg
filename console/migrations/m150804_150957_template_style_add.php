<?php

use yii\db\Schema;
use yii\db\Migration;

class m150804_150957_template_style_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%template}}', 'style', Schema::TYPE_TEXT);
    }

    public function down()
    {
        $this->dropColumn('{{%template}}', 'style');
    }
}
