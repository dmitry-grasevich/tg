<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use common\models\TemplateCategory;
use yii\helpers\ArrayHelper;
use common\models\Css;
use common\models\Js;
use common\models\Functions;

/**
 * @var yii\web\View $this
 * @var common\models\Template $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-view">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
