<?php

namespace common\models\comments;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

abstract class Comment extends ActiveRecord
{
    public static function instantiate($row)
    {
        return new AdjacencyListComment();
    }

    public static function create($config = [])
    {
        return new AdjacencyListComment($config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            ['class' => BlameableBehavior::className(), 'createdByAttribute' => 'author_id', 'updatedByAttribute' => false],
        ];
    }

    public function rules()
    {
        return [
            ['text', 'filter', 'filter' => 'trim'],
            ['text', 'required'],
            ['text', 'string', 'min' => 5, 'max' => 10000],
        ];
    }
}
