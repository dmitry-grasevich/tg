<?php

use yii\db\Schema;
use yii\db\Migration;

class m141116_193841_element_fields_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%element}}', 'description', Schema::TYPE_STRING . ' DEFAULT ""');
        $this->addColumn('{{%element}}', 'priority', Schema::TYPE_INTEGER . ' DEFAULT "0"');
        $this->addColumn('{{%element}}', 'css_selector', Schema::TYPE_STRING . ' DEFAULT ""');
    }

    public function down()
    {
        $this->dropColumn('{{%element}}', 'description');
        $this->dropColumn('{{%element}}', 'priority');
        $this->dropColumn('{{%element}}', 'css_selector');
    }
}
