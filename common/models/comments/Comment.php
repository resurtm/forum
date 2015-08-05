<?php

namespace common\models\comments;

use yii\db\ActiveRecord;

abstract class Comment extends ActiveRecord
{
    public static function instantiate($row)
    {
        return new AdjacencyListComment();
    }

    public static function create()
    {
        return new AdjacencyListComment();
    }
}
