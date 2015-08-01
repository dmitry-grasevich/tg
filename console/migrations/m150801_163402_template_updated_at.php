<?php

use yii\db\Schema;
use yii\db\Migration;

class m150801_163402_template_updated_at extends Migration
{
    public function up()
    {
        $this->addColumn('{{%template}}', 'updated_at', Schema::integer());
    }

    public function down()
    {
        $this->dropColumn('{{%template}}', 'updated_at');
    }
}
