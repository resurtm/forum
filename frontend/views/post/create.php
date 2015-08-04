<?php
/** @var $this frontend\components\View */
/** @var $post common\models\Post */
/** @var $rootSections common\models\Section[] */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = $post->getIsNewRecord() ? 'Create new post' : 'Update post';

$this->registerJsVariable(
    'sectionChildrenUrl',
    'function (id) { return ' . Json::encode(Url::toRoute(['section/children', 'id' => 9999])) . '.replace("9999", id); }'
);
?>
<div class="post-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'post-create-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'validateOnChange' => false,
        'validateOnBlur' => false,
    ]); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($post, 'title') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <?= $form
                    ->field($post, 'rootSectionId')
                    ->dropDownList(ArrayHelper::map($rootSections, 'id', 'title'), ['prompt' => '', 'autocomplete' => 'off']) ?>
            </div>
            <div class="col-md-3">
                <?= $form
                    ->field($post, 'section_id')
                    ->dropDownList([], ['disabled' => true, 'autocomplete' => 'off']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($post, 'text')->textarea(['rows' => 10]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Create', ['class' => 'btn btn-danger', 'name' => 'signup-button']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
