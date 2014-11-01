<?php

use yii\db\Schema;
use yii\db\Migration;

class m141101_091530_template_category_alias_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%template_category}}', 'alias', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('{{%template_category}}', 'alias');
    }
}
