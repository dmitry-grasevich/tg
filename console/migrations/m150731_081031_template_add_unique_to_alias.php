<?php

use yii\db\Schema;
use yii\db\Migration;

class m150731_081031_template_add_unique_to_alias extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%template}}', 'alias', $this->string()->notNull()->unique());
    }

    public function down()
    {
        echo "m150731_081031_template_add_unique_to_alias cannot be reverted.\n";

        return false;
    }
}
