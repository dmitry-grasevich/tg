<?php
use yii\db\Migration;

class m150804_175950_common_file_name_remove extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%common_file}}', 'name');
    }

    public function down()
    {
        $this->addColumn('{{%common_file}}', 'name', $this->string());
    }
}
