<?php
/** @var $this yii\web\View */
/** @var $post common\models\Post */
/** @var $comment common\models\comments\Comment */
/** @var $comments mixed[][] */

use yii\helpers\Html;

$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => $post->section->parent->title, 'url' => $post->section->parent->getUrl()];
$this->params['breadcrumbs'][] = ['label' => $post->section->title, 'url' => $post->section->getUrl()];
$this->params['breadcrumbs'][] = $post->title;
?>
<div class="post-view">
    <h1><?= Html::encode($post->title) ?></h1>
    <p><?= Yii::$app->getFormatter()->asNtext($post->text) ?></p>

    <h3>Comments</h3>
    <?php foreach ($comments as $item): ?>
        <?= $this->render('/comment/_item', ['comment' => $item]) ?>
    <?php endforeach; ?>
    <?= $this->render('/comment/_form', ['comment' => $comment]) ?>
</div>
