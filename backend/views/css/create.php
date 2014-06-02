<?php
/**
 * @var yii\web\View $this
 * @var common\models\Css $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Css',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Csses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="css-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
