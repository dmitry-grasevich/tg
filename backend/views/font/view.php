<?php

/**
 * @var yii\web\View $this
 * @var common\models\Font $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Fonts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="font-view">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
