<?php

/**
 * @var yii\web\View $this
 * @var common\models\Css $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Css'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="css-view">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
