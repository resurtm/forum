<?php
/** @var $this yii\web\View */
/** @var $sections common\models\Section[] */

use yii\helpers\Html;

$this->title = 'Forum';
?>
<div class="site-index">
    <?php foreach ($sections as $section): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::a(Html::encode($section->title), $section->getUrl()) ?></h3>
            </div>

            <?php if (count($section->children) > 0): ?>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($section->children as $child): ?>
                                <tr>
                                    <td><?= Html::a(Html::encode($child->title), $child->getUrl()) ?></td>
                                    <td></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
