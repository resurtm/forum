<?php

namespace common\models\comment;

use yii\db\ActiveRecord;

class AdjacencyListComment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_al}}';
    }
}
