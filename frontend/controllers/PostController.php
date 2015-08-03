<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use common\models\Post;
use common\models\Section;

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

    public function actionCreate()
    {
        $post = new Post();

        if ($post->load(Yii::$app->getRequest()->post()) && $post->save()) {
            return $this->redirect($post->getUrl());
        } else {
            $rootSections = Section::find()
                ->roots()
                ->orderBy('title')
                ->all();

            return $this->render('create', [
                'post' => $post,
                'rootSections' => $rootSections,
            ]);
        }
    }
}
