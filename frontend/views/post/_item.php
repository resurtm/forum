<?php
/** @var $this yii\web\View */
/** @var $model common\models\Post */
/** @var $key mixed */
/** @var $index integer */
/** @var $widget yii\widgets\ListView */

use yii\helpers\Html;
?>
<tr>
    <td><?= Html::a(Html::encode($model->title), $model->getUrl()) ?></td>
</tr>
