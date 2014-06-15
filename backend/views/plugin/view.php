<?php

/**
 * @var yii\web\View $this
 * @var common\models\Plugin $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plugins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plugin-view">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
