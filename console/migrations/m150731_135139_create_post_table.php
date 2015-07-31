<?php

use yii\db\Schema;
use console\components\Migration;

class m150731_135139_create_post_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%post}}', [
            'id' => Schema::TYPE_PK,

            'section_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'author_id' => Schema::TYPE_INTEGER . ' NOT NULL',

            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'slug' => Schema::TYPE_STRING . ' NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createIndex('post__section_id', '{{%post}}', 'section_id');
        $this->addForeignKey('post__section_id', '{{%post}}', 'section_id', '{{%section}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('post__author_id', '{{%post}}', 'author_id');
        $this->addForeignKey('post__author_id', '{{%post}}', 'author_id', '{{%section}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('post__section_id', '{{%post}}');
        $this->dropIndex('post__section_id', '{{%post}}');

        $this->dropForeignKey('post__author_id', '{{%post}}');
        $this->dropIndex('post__author_id', '{{%post}}');

        $this->dropTable('{{%post}}');
    }
}
