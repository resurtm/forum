<?php
/** @var $this yii\web\View */
/** @var $post common\models\Post */

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => $post->section->parent->title, 'url' => $post->section->parent->getUrl()];
$this->params['breadcrumbs'][] = ['label' => $post->section->title, 'url' => $post->section->getUrl()];
$this->params['breadcrumbs'][] = $post->title;
?>
<div class="post-view">
    <h1><?= Html::encode($post->title) ?></h1>
    <p><?= Yii::$app->getFormatter()->asNtext($post->text) ?></p>
</div>
