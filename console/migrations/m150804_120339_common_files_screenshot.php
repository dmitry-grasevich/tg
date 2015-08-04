<?php

use yii\db\Schema;
use yii\db\Migration;

class m150804_120339_common_files_screenshot extends Migration
{
    public function up()
    {
        $this->insert('{{%common_file}}', [
            'name' => 'Screenshot',
            'filename' => 'screenshot.png',
            'code' => 'screenshot.png',
        ]);
    }

    public function down()
    {
        echo "m150804_120339_common_files_screenshot cannot be reverted.\n";

        return false;
    }
}
