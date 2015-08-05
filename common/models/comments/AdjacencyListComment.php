<?php

namespace common\models\comments;

class AdjacencyListComment extends Comment
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_al}}';
    }

    public static function findByPostInternal($postId)
    {
        $comments = static::find()
            ->select(['id', 'parent_id', 'author_id', 'text', 'created_at'])
            ->where(['post_id' => $postId])
            ->asArray()
            ->all();

        $root = ['id' => null, 'children' => []];
        static::prepareComments($root, $comments);
        unset($comments);

        return $root['children'];
    }

    private static function prepareComments(&$parentNode, &$comments)
    {
        foreach ($comments as $i => &$childNode) {
            if (is_integer($childNode['id'])) {
                continue;
            }
            if (!isset($childNode['children'])) {
                $childNode['children'] = [];
            }
            if ($parentNode['id'] == $childNode['parent_id']) {
                $parentNode['children'][] = &$childNode;

                $childNode['id'] = (integer)$childNode['id'];
                $childNode['parent_id'] = (integer)$childNode['parent_id'];
                $childNode['author_id'] = (integer)$childNode['author_id'];
                $childNode['created_at'] = (integer)$childNode['created_at'];
            }
        }
        foreach ($parentNode['children'] as $i => &$childNode) {
            static::prepareComments($childNode, $comments);
        }
    }
}
