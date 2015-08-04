<?php

use yii\db\Schema;
use console\components\Migration;

class m150804_073905_create_nested_set_comment_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%comment_ns}}', [
            'id' => Schema::TYPE_PK,

            'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'author_id' => Schema::TYPE_INTEGER . ' NOT NULL',

            'left' => Schema::TYPE_INTEGER . ' NOT NULL',
            'right' => Schema::TYPE_INTEGER . ' NOT NULL',
            'level' => Schema::TYPE_INTEGER . ' NOT NULL',

            'text' => Schema::TYPE_TEXT . ' NOT NULL',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createIndex('comment_ns__post_id', '{{%comment_ns}}', 'post_id');
        $this->addForeignKey('comment_ns__post_id', '{{%comment_ns}}', 'post_id', '{{%post}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('comment_ns__author_id', '{{%comment_ns}}', 'author_id');
        $this->addForeignKey('comment_ns__author_id', '{{%comment_ns}}', 'author_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('comment_ns__post_id', '{{%comment_ns}}');
        $this->dropIndex('comment_ns__post_id', '{{%comment_ns}}');

        $this->dropForeignKey('comment_ns__author_id', '{{%comment_ns}}');
        $this->dropIndex('comment_ns__author_id', '{{%comment_ns}}');

        $this->dropTable('{{%comment_ns}}');
    }
}
