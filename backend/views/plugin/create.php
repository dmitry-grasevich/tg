<?php

/**
 * @var yii\web\View $this
 * @var common\models\Plugin $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Plugin',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plugins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plugin-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
