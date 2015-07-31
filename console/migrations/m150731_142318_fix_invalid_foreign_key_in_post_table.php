<?php

use yii\db\Schema;
use console\components\Migration;

class m150731_142318_fix_invalid_foreign_key_in_post_table extends Migration
{
    public function up()
    {
        $this->dropForeignKey('post__author_id', '{{%post}}');
        $this->addForeignKey('post__author_id', '{{%post}}', 'author_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('post__author_id', '{{%post}}');
        $this->addForeignKey('post__author_id', '{{%post}}', 'author_id', '{{%section}}', 'id', 'CASCADE', 'RESTRICT');
    }
}
