<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Css $model
 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Css',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Csses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="css-update">

    <?=
    $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
