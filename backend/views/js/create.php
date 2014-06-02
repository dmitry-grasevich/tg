<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Js $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Js',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Js'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="js-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?=
    $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
