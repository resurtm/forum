<?php
/** @var $this yii\web\View */
/** @var $section common\models\Section */

use yii\helpers\Html;

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
    <h1><?= Html::encode($this->title) ?></h1>
</div>
