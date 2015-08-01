<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Control $searchModel
 */

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\Control;

$this->title = Yii::t('tg', 'Controls');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="control-index">
    <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Add Control', ['create'], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'resizableColumns' => false,
        'columns' => [
            'name',
            [
                'attribute' => 'family',
                'format' => 'raw',
                'value' => function($model) {
                    /** @var \common\models\Control $model */
                    $families = Control::listFamilies();
                    return empty($model->family) || !isset($families[$model->family]) ? '' : Html::encode($families[$model->family]);
                }
            ],
            'type',
            'class',
            [
                'attribute' => 'params',
                'format' => 'raw',
                'value' => function($model) {
                    /** @var \common\models\Control $model */
                    return empty($model->params) ? '' : Html::tag('pre', Html::tag('code', Html::encode($model->params), ['class' => 'css']), ['class' => 'scroll']);
                }
            ],
            [
                'attribute' => 'css',
                'format' => 'raw',
                'value' => function($model) {
                    /** @var \common\models\Control $model */
                    return empty($model->css) ? '' : Html::tag('pre', Html::tag('code', Html::encode($model->css), ['class' => 'css']), ['class' => 'scroll']);
                }
            ],
            [
                'header' => 'Preview Image',
                'attribute' => 'img',
                'format' => 'raw',
                'value' => function($model) {
                    /** @var \common\models\Control $model */
                    return !empty($model->img) ? Html::img(Control::getImagePath() . '/' . $model->img, ['style' => 'max-width: 300px;']) : false;
                }
            ],

/*            [
                'attribute' => 'code',
                'format' => 'raw',
                'value' => function($model) {
                    return '<pre class="scroll"><code class="php">' . Html::encode($model->code) . '</code></pre>';
                }
            ],
            [
                'attribute' => 'styles_code',
                'format' => 'raw',
                'value' => function($model) {
                    return empty($model->styles_code) ? '' : '<pre class="scroll"><code class="php">' . Html::encode($model->styles_code) . '</code></pre>';
                }
            ],
*/
            [
                'class' => 'yii\grid\ActionColumn',
                'options' => [
                    'width' => 60,
                ],
                'buttons' => [
                    'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['control/view', 'id' => $model->id, 'edit' => 't']), [
                                'title' => Yii::t('yii', 'Edit'),
                            ]);
                        }
                ],
            ],
        ],
        'responsive' => false,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,
        'export' => false,
        'pjax' => true,
    ]) ?>
</div>


<?php
$js = <<<JS
hljs.initHighlightingOnLoad();
$('pre.scroll').perfectScrollbar({ suppressScrollX: true });
JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'template-view-script');