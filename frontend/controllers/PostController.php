<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use common\models\Post;
use common\models\Section;
use common\models\comments\Comment;

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

        $commentClass = Comment::className();
        $comment = new $commentClass();

        return $this->render('view', ['post' => $post, 'comment' => $comment]);
    }

    public function actionCreate($id = null)
    {
        if ($id === null) {
            $post = new Post();
        } else {
            if (($post = Post::findOne(['id' => $id, 'author_id' => Yii::$app->getUser()->getId()])) === null) {
                throw new HttpException(404, 'Cannot find the requested post.');
            }
        }

        if (Yii::$app->getRequest()->getIsAjax() && $post->load(Yii::$app->request->post())) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return ActiveForm::validate($post);
        }

        if ($post->load(Yii::$app->getRequest()->post()) && $post->save()) {
            return $this->redirect(Post::findOne($id)->getUrl());
        } else {
            $rootSections = Section::find()
                ->roots()
                ->orderBy('title')
                ->all();
            $mainSections = $post->rootSectionId === null
                ? []
                : Section::find()
                    ->where(['section_id' => $post->rootSectionId])
                    ->orderBy('title')
                    ->all();

            return $this->render('create', [
                'post' => $post,
                'rootSections' => $rootSections,
                'mainSections' => $mainSections,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        return $this->actionCreate($id);
    }
}
