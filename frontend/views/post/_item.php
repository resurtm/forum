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
    <td>
        <?php if ($model->author_id == Yii::$app->getUser()->getId()): ?>
            <?= Html::a('Edit', ['post/update', 'id' => $model->id], ['class' => 'btn btn-xs btn-primary']) ?>
            <?= Html::a('Delete', ['post/delete', 'id' => $model->id], ['class' => 'btn btn-xs btn-danger']) ?>
        <?php endif; ?>
    </td>
    <td><?= Yii::$app->getFormatter()->asDatetime($model->created_at) ?></td>
    <td><?= Yii::$app->getFormatter()->asDatetime($model->updated_at) ?></td>
</tr>
