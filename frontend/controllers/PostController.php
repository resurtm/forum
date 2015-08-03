<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\HttpException;
use common\models\Post;

class PostController extends Controller
{
    public function actionView($id, $slug, $parentSectionId, $parentSectionSlug, $childSectionId, $childSectionSlug)
    {
        /** @var Post $post */
        $post = Post::find()
            ->where(['id' => $id, 'slug' => $slug])
            ->with(['section', 'section.parent'])
            ->one();

        if ($post === null ||
            $post->section->parent->id != $parentSectionId || $post->section->parent->slug != $parentSectionSlug ||
            $post->section->id != $childSectionId || $post->section->slug != $childSectionSlug) {
            throw new HttpException(404, 'Cannot find the requested post.');
        }

        return $this->render('view', ['post' => $post]);
    }
}
