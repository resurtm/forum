<?php
/** @var $this yii\web\View */
/** @var $section common\models\Section */

use yii\helpers\Html;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= Html::a(Html::encode($section->title), $section->getUrl()) ?>
            (<?= Yii::t('app', '{n, plural, =0{no posts} =1{one post} other{# posts}}', ['n' => $section->postCount]) ?>)
        </h3>
    </div>

    <?php if (count($section->children) > 0): ?>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60%;">Title</th>
                        <th style="width: 40%;">Post count</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($section->children as $child): ?>
                        <tr>
                            <td><?= Html::a(Html::encode($child->title), $child->getUrl()) ?></td>
                            <td><?= Yii::t('app', '{n, plural, =0{No posts} =1{One post} other{# posts}}', ['n' => $child->postCount]) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
