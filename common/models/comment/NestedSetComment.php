<?php

namespace common\models\comment;

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
