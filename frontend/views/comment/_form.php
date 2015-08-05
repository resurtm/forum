<?php
/** @var $this yii\web\View */
/** @var $comment common\models\comments\Comment */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin([
    'id' => 'comment-create-form',
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'validateOnChange' => false,
    'validateOnBlur' => false,
]); ?>
    <div class="row">
    <div class="col-md-5">
        <?= $form->field($comment, 'text', ['enableLabel' => false])->textarea() ?>
        <div class="form-group">
            <?= Html::submitButton('Comment', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    </div>
<?php ActiveForm::end(); ?>
