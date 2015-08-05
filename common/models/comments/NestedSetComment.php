<?php

namespace common\models\comments;

class NestedSetComment extends Comment
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_ns}}';
    }
}
