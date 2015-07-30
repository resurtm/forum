<?php

use yii\db\Schema;
use console\components\Migration;

class m150730_104001_create_section_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%section}}', [
            'id' => Schema::TYPE_PK,

            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'slug' => Schema::TYPE_STRING . ' NOT NULL',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%section}}');
    }
}
