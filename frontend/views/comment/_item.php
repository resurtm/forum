<?php
/** @var $this yii\web\View */
/** @var $comment mixed[][] */
?>
<div class="row">
<div class="col-lg-5 <?php if ($comment['level'] > 1): ?>col-lg-offset-<?= (int)$comment['level'] - 1 ?><?php endif; ?>">
<div class="well well-sm">
    <p><?= Yii::$app->getFormatter()->asNtext($comment['text']) ?></p>
</div>
</div>
</div>

<?php foreach ($comment['children'] as $item): ?>
    <?= $this->render('/comment/_item', ['comment' => $item]) ?>
<?php endforeach; ?>
