<?php
/** @var $this yii\web\View */
/** @var $sections common\models\Section[] */

use yii\helpers\Html;

$this->title = 'Forum';
?>
<div class="site-index">
    <div class="row header-actions">
        <div class="col-sm-3">
            <?= Html::a('Create a new post', ['post/create'], ['class' => 'btn btn-block btn-success']) ?>
        </div>
    </div>

    <?php foreach ($sections as $section): ?>
        <?= $this->render('/section/_item', ['section' => $section]) ?>
    <?php endforeach; ?>
</div>
