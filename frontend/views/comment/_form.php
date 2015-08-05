<?php
/** @var $this yii\web\View */
/** @var $comment common\models\comments\Comment */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<p><?= Html::a('Leave a new comment', '#', ['id' => 'create-new-comment']) ?></p>

<div class="row">
<div class="col-md-5">
    <?php $form = ActiveForm::begin([
        'id' => 'comment-create-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'validateOnChange' => false,
        'validateOnBlur' => false,
    ]); ?>
        <?= $form->field($comment, 'parent_id', ['enableLabel' => false, 'enableError' => false])->hiddenInput(['class' => 'parent']) ?>
        <?= $form->field($comment, 'text', ['enableLabel' => false])->textarea(['rows' => 5]) ?>
        <div class="form-group">
            <?= Html::submitButton('Comment', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
