<?php

namespace common\models\comments;

class AdjacencyListComment extends Comment
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_al}}';
    }
}
