<?php
/** @var $this yii\web\View */
/** @var $sections common\models\Section[] */

use yii\helpers\Html;

$this->title = 'Forum';
?>
<div class="site-index">
    <?php foreach ($sections as $section): ?>
        <?= $this->render('/section/_item', ['section' => $section]) ?>
    <?php endforeach; ?>
</div>
