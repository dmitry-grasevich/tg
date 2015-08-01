<?php

use yii\db\Schema;
use yii\db\Migration;

class m150801_125217_section_control_new_fields_add extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%section_control}}', 'default');
        $this->addColumn('{{%section_control}}', 'alias', Schema::string()->notNull());
        $this->addColumn('{{%section_control}}', 'label', Schema::string()->notNull());
        $this->addColumn('{{%section_control}}', 'help', Schema::string());
        $this->addColumn('{{%section_control}}', 'description', Schema::text());
        $this->addColumn('{{%section_control}}', 'default', Schema::text());
        $this->addColumn('{{%section_control}}', 'style', Schema::text());
        $this->addColumn('{{%section_control}}', 'params', Schema::text());
        $this->addColumn('{{%section_control}}', 'pseudojs', Schema::text());
    }

    public function down()
    {
        $this->dropColumn('{{%section_control}}', 'alias');
        $this->dropColumn('{{%section_control}}', 'label');
        $this->dropColumn('{{%section_control}}', 'help');
        $this->dropColumn('{{%section_control}}', 'description');
        $this->dropColumn('{{%section_control}}', 'default');
        $this->dropColumn('{{%section_control}}', 'style');
        $this->dropColumn('{{%section_control}}', 'params');
        $this->dropColumn('{{%section_control}}', 'pseudojs');
        $this->addColumn('{{%section_control}}', 'default', Schema::string());
    }
}
