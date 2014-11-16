<?php

use yii\db\Schema;
use yii\db\Migration;

class m141116_123616_control_style_code_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%control}}', 'styles_code', Schema::TYPE_TEXT);
    }

    public function down()
    {
        $this->dropColumn('{{%control}}', 'styles_code');
    }
}
