<?php

namespace common\models\comments;

use yii\db\ActiveQuery;

abstract class Comment
{
    public static function className()
    {
        return AdjacencyListComment::className();
    }

    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return call_user_func([static::className(), 'find']);
    }
}
