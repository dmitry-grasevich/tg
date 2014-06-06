<?php

/**
 * @var yii\web\View $this
 * @var common\models\Image $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Image',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
