<?php

namespace common\models\comments;

use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

abstract class Comment extends ActiveRecord
{
    public static function commentClassName()
    {
        //return AdjacencyListComment::className();
        return NestedSetComment::className();
        //return MaterializedPathComment::className();
    }

    public static function instantiate($row)
    {
        $className = static::commentClassName();
        return new $className();
    }

    /**
     * @param mixed[] $config
     * @return Comment
     */
    public static function create($config = [])
    {
        $className = static::commentClassName();
        return new $className($config);
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

            ['parent_id', 'exist', 'targetAttribute' => 'id'],
        ];
    }

    public static function findByPostInternal($postId)
    {
        throw new Exception('Method is not implemented');
    }

    public static function findByPost($postId)
    {
        return call_user_func([static::commentClassName(), 'findByPostInternal'], $postId);
    }
}
