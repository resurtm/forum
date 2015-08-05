<?php

use yii\db\Schema;
use console\components\Migration;

class m150805_151602_fix_invalid_fk_in_adjacency_list_comment_table extends Migration
{
    public function up()
    {
        $this->dropForeignKey('comment_al__parent_id', '{{comment_al}}');
        $this->addForeignKey('comment_al__parent_id', '{{comment_al}}', 'parent_id', '{{%comment_al}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('comment_al__parent_id', '{{comment_al}}');
        $this->addForeignKey('comment_al__parent_id', '{{comment_al}}', 'parent_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }
}
