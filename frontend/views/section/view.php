<?php
/** @var $this yii\web\View */
/** @var $section common\models\Section */
/** @var $posts yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\widgets\ListView;

if ($section->parent === null) {
    $this->title = $section->title;
    $this->params['breadcrumbs'][] = $section->title;
} else {
    $this->title = $section->parent->title . ' → ' . $section->title;
    $this->params['breadcrumbs'][] = ['label' => $section->parent->title, 'url' => $section->parent->getUrl()];
    $this->params['breadcrumbs'][] = $section->title;
}
?>
<div class="section-view">
    <h1><?= Html::encode($section->title) ?></h1>

    <?php if ($section->section_id === null): ?>
        <?= $this->render('/section/_item', ['section' => $section]) ?>
    <?php endif; ?>

    <?= ListView::widget([
        'dataProvider' => $posts,
        'itemView' => '/post/_item',
        'layout' => '<tr><td>Title</td><td></td><td>Created</td><td>Updated</td></tr>' .
            '{items}' .
            '<tr><td colspan="4">{pager}</td></tr>',
        'options' => ['tag' => 'table', 'class' => 'table'],
        'itemOptions' => ['tag' => false],
    ]) ?>
</div>
