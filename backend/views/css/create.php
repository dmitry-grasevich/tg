<?php
/**
 * @var yii\web\View $this
 * @var common\models\Css $model
 */

$this->title = Yii::t('tg', 'Create {modelClass}', [
    'modelClass' => 'Css',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'CSSes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="css-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
