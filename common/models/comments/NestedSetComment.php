<?php

namespace common\models\comments;

use yii\db\ActiveRecord;

class NestedSetComment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_ns}}';
    }
}
