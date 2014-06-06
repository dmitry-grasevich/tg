<?php

/**
 * @var yii\web\View $this
 * @var common\models\Image $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-view">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
