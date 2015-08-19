<?php
/**
 * @var yii\web\View $this
 * @var common\models\Js $model
 */

$this->title = Yii::t('tg', 'Create {modelClass}', [
    'modelClass' => 'Js',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Js'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="js-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
