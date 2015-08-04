<?php

use yii\db\Schema;
use console\components\Migration;

class m150804_080424_create_adjacency_list_comment_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%comment_al}}', [
            'id' => Schema::TYPE_PK,

            'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'author_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'parent_id' => Schema::TYPE_INTEGER . ' NULL',

            'text' => Schema::TYPE_TEXT . ' NOT NULL',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createIndex('comment_al__post_id', '{{%comment_al}}', 'post_id');
        $this->addForeignKey('comment_al__post_id', '{{%comment_al}}', 'post_id', '{{%post}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('comment_al__author_id', '{{%comment_al}}', 'author_id');
        $this->addForeignKey('comment_al__author_id', '{{%comment_al}}', 'author_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('comment_al__parent_id', '{{%comment_al}}', 'parent_id');
        $this->addForeignKey('comment_al__parent_id', '{{%comment_al}}', 'parent_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('comment_al__post_id', '{{%comment_al}}');
        $this->dropIndex('comment_al__post_id', '{{%comment_al}}');

        $this->dropForeignKey('comment_al__author_id', '{{%comment_al}}');
        $this->dropIndex('comment_al__author_id', '{{%comment_al}}');

        $this->dropForeignKey('comment_al__parent_id', '{{%comment_al}}');
        $this->dropIndex('comment_al__parent_id', '{{%comment_al}}');

        $this->dropTable('{{%comment_al}}');
    }
}
