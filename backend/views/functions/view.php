<?php
/**
 * @var yii\web\View $this
 * @var common\models\Functions $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Functions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="functions-view">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
