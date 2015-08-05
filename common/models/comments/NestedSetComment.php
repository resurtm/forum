<?php

namespace common\models\comments;

use yii\base\Exception;

class NestedSetComment extends Comment
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_ns}}';
    }

    public static function findByPostInternal($postId)
    {
        throw new Exception('Method is not implemented');
    }
}
