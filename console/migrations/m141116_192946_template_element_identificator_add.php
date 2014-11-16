<?php

use yii\db\Schema;
use yii\db\Migration;

class m141116_192946_template_element_identificator_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%template}}', 'identificator', Schema::TYPE_STRING);
        $this->addColumn('{{%element}}', 'identificator', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('{{%template}}', 'identificator');
        $this->dropColumn('{{%element}}', 'identificator');
    }
}
