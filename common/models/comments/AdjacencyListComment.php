<?php

namespace common\models\comments;

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
