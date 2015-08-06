<?php

use yii\db\Schema;
use console\components\Migration;

class m150806_033844_create_materialized_path_comment_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%comment_mp}}', [
            'id' => Schema::TYPE_PK,

            'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'author_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'path' => Schema::TYPE_STRING . '(250) NOT NULL',

            'text' => Schema::TYPE_TEXT . ' NOT NULL',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createIndex('comment_mp__post_id', '{{%comment_mp}}', 'post_id');
        $this->addForeignKey('comment_mp__post_id', '{{%comment_mp}}', 'post_id', '{{%post}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('comment_mp__author_id', '{{%comment_mp}}', 'author_id');
        $this->addForeignKey('comment_mp__author_id', '{{%comment_mp}}', 'author_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('comment_mp__post_id', '{{%comment_mp}}');
        $this->dropIndex('comment_mp__post_id', '{{%comment_mp}}');

        $this->dropForeignKey('comment_mp__author_id', '{{%comment_mp}}');
        $this->dropIndex('comment_mp__author_id', '{{%comment_mp}}');

        $this->dropTable('{{%comment_mp}}');
    }
}
