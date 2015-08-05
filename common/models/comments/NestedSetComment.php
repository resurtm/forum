<?php

namespace common\models\comments;

use yii\db\Query;

class NestedSetComment extends Comment
{
    public $parent_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_ns}}';
    }

    public static function findByPostInternal($postId)
    {
        return [];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $query = new Query();
        $query
            ->select('COUNT(*)')
            ->where(['post_id' => $this->post_id])
            ->from(static::tableName());
        $count = $query->scalar($this->getDb());

        if ($count == 0) {
            $this->left = 1;
            $this->right = 2;
            $this->level = 1;
        } else {
            if (empty($this->parent_id)) {
                $query = new Query();
                $query
                    ->select('MAX({{right}})')
                    ->where(['post_id' => $this->post_id])
                    ->from(static::tableName());
                $maxRight = $query->scalar($this->getDb());

                $this->left = $maxRight + 1;
                $this->right = $maxRight + 2;
                $this->level = 1;
            } else {

            }
        }

        return true;
    }
}
