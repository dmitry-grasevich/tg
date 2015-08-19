<?php

use yii\db\Schema;
use yii\db\Migration;

class m150801_130255_section_new_fields_add extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%section}}', 'name');
        $this->dropColumn('{{%section}}', 'code');
        $this->addColumn('{{%section}}', 'template_id', $this->integer()->notNull());
        $this->addColumn('{{%section}}', 'alias', $this->string()->notNull());
        $this->addColumn('{{%section}}', 'title', $this->string()->notNull());
        $this->addColumn('{{%section}}', 'description', $this->text());

        $this->dropForeignKey('fk_section_control_section', '{{%section_control}}');
        $this->truncateTable('{{%section}}');
        $this->addForeignKey('fk_section_template', '{{%section}}', 'template_id', '{{%template}}', 'id', 'cascade');
        $this->addForeignKey('fk_section_control_section', '{{%section_control}}', 'section_id', '{{%section}}', 'id', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_section_template', '{{%section}}');

        $this->dropColumn('{{%section}}', 'template_id');
        $this->dropColumn('{{%section}}', 'alias');
        $this->dropColumn('{{%section}}', 'title');
        $this->dropColumn('{{%section}}', 'description');
        $this->addColumn('{{%section}}', 'name', $this->string()->notNull());
        $this->addColumn('{{%section}}', 'code', $this->text());

    }
}
