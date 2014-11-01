<?php

use yii\db\Schema;
use yii\db\Migration;

class m141101_114607_rename_template_category_to_category extends Migration
{
    public function up()
    {
        $this->renameTable('{{%template_category}}', '{{%category}}');
    }

    public function down()
    {
        $this->renameTable('{{%category}}', '{{%template_category}}');
    }
}
