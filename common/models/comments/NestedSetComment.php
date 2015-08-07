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
//            ->andWhere('parent.id = 1')
            ->andWhere('node.post_id = :pid AND parent.post_id = :pid', [':pid' => $postId])
            ->orderBy('node.{{left}}, node.created_at')
            ->groupBy('node.{{id}}');
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
                /*$query = new Query();
                $query
                    ->select(['{{left}} left', '{{level}} level'])
                    ->where(['post_id' => $this->post_id, 'id' => $this->parent_id])
                    ->from(static::tableName());
                $data1 = $query->all(static::getDb());

                static::getDb()
                    ->createCommand('UPDATE ' . static::tableName() . ' SET {{right}} = {{right}} + 2 WHERE {{right}} > :left')
                    ->bindValue(':left', $data1[0]['left'])
                    ->execute();

                static::getDb()
                    ->createCommand('UPDATE ' . static::tableName() . ' SET {{left}} = {{left}} + 2 WHERE {{left}} > :left')
                    ->bindValue(':left', $data1[0]['left'])
                    ->execute();

                $this->left = $data1[0]['left'] + 1;
                $this->right = $data1[0]['left'] + 2;
                $this->level = $data1[0]['level'] + 1;*/

                $query = new Query();
                $query
                    ->select(['id', '{{left}} left', '{{right}} right', '{{level}} level'])
                    ->where(['post_id' => $this->post_id, 'id' => $this->parent_id])
                    ->from(static::tableName());
                $data1 = $query->all(static::getDb());

                if ($data1[0]['left'] != $data1[0]['right'] - 1) {
                    $query = new Query();
                    $query
                        ->select(['id', '{{left}} left', '{{right}} right', '{{level}} level', '{{text}}'])
                        ->where(['post_id' => $this->post_id, 'level' => $data1[0]['level']])
                        ->andWhere('{{left}} > :r AND {{id}} != :id', [':r' => $data1[0]['right'], ':id' => $data1[0]['id']])
                        ->from(static::tableName());
                    $data2 = $query->one(static::getDb());

                    static::getDb()
                        ->createCommand('UPDATE ' . static::tableName() . ' SET {{right}} = {{right}} + 2 WHERE {{right}} > :left')
                        ->bindValue(':left', $data2['left'] - 2)
                        ->execute();

                    static::getDb()
                        ->createCommand('UPDATE ' . static::tableName() . ' SET {{left}} = {{left}} + 2 WHERE {{left}} > :left')
                        ->bindValue(':left', $data2['left'] - 2)
                        ->execute();


                    $this->left = $data2['right'] - 2;
                    $this->right = $data2['right'] - 1;
                    $this->level = $data1[0]['level'] + 1;
                } else {
                    static::getDb()
                        ->createCommand('UPDATE ' . static::tableName() . ' SET {{right}} = {{right}} + 2 WHERE {{right}} > :left')
                        ->bindValue(':left', $data1[0]['left'])
                        ->execute();

                    static::getDb()
                        ->createCommand('UPDATE ' . static::tableName() . ' SET {{left}} = {{left}} + 2 WHERE {{left}} > :left')
                        ->bindValue(':left', $data1[0]['left'])
                        ->execute();

                    $this->left = $data1[0]['left'] + 1;
                    $this->right = $data1[0]['left'] + 2;
                    $this->level = $data1[0]['level'] + 1;
                }


            }
        }

        return true;
    }
}
