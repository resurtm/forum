<?php

namespace common\models\comments;

class MaterializedPathComment extends Comment
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_mp}}';
    }
}
