<?php

use yii\db\Schema;
use yii\db\Migration;

class m150731_070250_template_new_attributes extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%common_file}}', [
            'id' => 'pk',
            'name' => $this->string()->notNull(),
            'filename' => $this->string()->notNull(),
            'directory' => $this->string(),
            'code' => $this->text(),
        ], $tableOptions);

        $this->insert('{{%common_file}}', [
            'name' => 'Index',
            'filename' => 'index.php',
        ]);

        $this->insert('{{%common_file}}', [
            'name' => 'Header',
            'filename' => 'header.php',
        ]);

        $this->insert('{{%common_file}}', [
            'name' => 'Footer',
            'filename' => 'footer.php',
        ]);

        $this->insert('{{%common_file}}', [
            'name' => 'Functions',
            'filename' => 'functions.php',
        ]);

        $this->insert('{{%common_file}}', [
            'name' => 'Styles',
            'filename' => 'style.css',
        ]);

        /**
         * Temporary drop foreign keys with template table
         * @TODO: restore it!
        */
        $this->dropForeignKey('fk_functions_parent', '{{%functions}}');
        $this->dropForeignKey('fk_css_parent', '{{%css}}');

        $this->delete('{{%template}}', 'id < 16');
        $this->delete('{{%template}}', 'id > 19');

        $this->addColumn('{{%template}}', 'alias', $this->string()->notNull());
        $this->addColumn('{{%template}}', 'title', $this->string()->notNull());
        $this->addColumn('{{%template}}', 'description', $this->text());
        $this->dropColumn('{{%template}}', 'filename');
        $this->dropColumn('{{%template}}', 'directory');
        $this->dropColumn('{{%template}}', 'identificator');

        $this->update('{{%template}}', ['alias' => 'footer-1'], ['id' => 16]);
        $this->update('{{%template}}', ['alias' => 'header-1'], ['id' => 17]);
        $this->update('{{%template}}', ['alias' => 'contact-1'], ['id' => 18]);
        $this->update('{{%template}}', ['alias' => 'header-bw'], ['id' => 19]);
    }

    public function down()
    {
        echo "m150731_070250_template_new_attributes cannot be reverted.\n";

        return false;
    }
}
