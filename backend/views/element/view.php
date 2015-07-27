<?php

/**
 * @var yii\web\View $this
 * @var common\models\Element $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Elements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="element-view">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
