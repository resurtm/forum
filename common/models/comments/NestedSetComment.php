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
        $query = new Query();
        $query
            ->select(['node.id', 'node.text', 'node.level'])
            ->from([static::tableName() . ' node', static::tableName() . ' parent'])
            ->where('node.left BETWEEN parent.{{left}} AND parent.{{right}}')
            //->andWhere('parent.id = 1')
            ->andWhere('node.post_id = :pid AND parent.post_id = :pid', [':pid' => $postId])
            ->orderBy('node.{{left}}');
        $comments = $query->all(static::getDb());
        foreach ($comments as &$comment) {
            $comment['children'] = [];
        }
        return $comments;
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
        $count = $query->scalar(static::getDb());

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
                $maxRight = $query->scalar(static::getDb());

                $this->left = $maxRight + 1;
                $this->right = $maxRight + 2;
                $this->level = 1;
            } else {

            }
        }

        return true;
    }
}
