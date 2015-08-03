<?php
/** @var $this yii\web\View */
/** @var $post common\models\Post */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Create new post';
?>
<div class="post-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-6">
            <?php $form = ActiveForm::begin(['id' => 'post-create-form']); ?>
                <?= $form->field($post, 'title') ?>
                <?= $form->field($post, 'text')->textarea(['rows' => 10]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Create', ['class' => 'btn btn-danger', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
