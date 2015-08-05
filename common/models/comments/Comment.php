<?php

namespace common\models\comments;

use yii\db\ActiveQuery;

abstract class Comment
{
    private static function childClassName()
    {
        return AdjacencyListComment::className();
    }

    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return call_user_func([static::childClassName(), 'find']);
    }
}
