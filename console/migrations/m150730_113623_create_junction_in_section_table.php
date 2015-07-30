<?php

use yii\db\Schema;
use console\components\Migration;

class m150730_113623_create_junction_in_section_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%section}}', 'section_id', Schema::TYPE_INTEGER . ' NULL DEFAULT NULL');
        $this->createIndex('section__section_id', '{{%section}}', 'section_id');
        $this->addForeignKey('section__section_id', '{{%section}}', 'section_id', '{{%section}}', 'id', 'SET NULL', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('section__section_id', '{{%section}}');
        $this->dropIndex('section__section_id', '{{%section}}');
        $this->dropColumn('{{%section}}', 'section_id');
    }
}
