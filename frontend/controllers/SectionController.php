<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\models\Section;

class SectionController extends Controller
{
    public function actionView($id, $slug, $parentId = null, $parentSlug = null)
    {
        /** @var Section $section */
        $section = Section::find()
            ->where(['id' => $id, 'slug' => $slug])
            ->with('parent')
            ->one();

        if ($section === null || $parentId !== null && $parentSlug !== null &&
            ($section->parent->id != $parentId || $section->parent->slug != $parentSlug)) {
            throw new HttpException(404, 'Cannot find the requested section.');
        }

        return $this->render('view', [
            'section' => $section,
            'posts' => $section->findPosts(),
        ]);
    }

    public function actionChildren($id)
    {
        $sections = Section::find()
            ->where(['section_id' => $id])
            ->orderBy('title')
            ->all();

        return Json::encode(ArrayHelper::map($sections, 'id', 'title'));
    }
}
