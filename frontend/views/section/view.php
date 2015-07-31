<?php
/** @var $this yii\web\View */
/** @var $section common\models\Section */

use yii\helpers\Html;

$this->title = $section->parent === null ? $section->title : $section->parent->title . ' → ' . $section->title;
?>
<div class="section-view">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
