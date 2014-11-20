<?php

namespace backend\controllers;

use Yii;
use common\models\Section;
use common\models\search\Section as SectionSearch;
use yii\helpers\ArrayHelper;
use backend\actions\SectionViewAction;
use yii\web\Response;

/**
 * SectionController implements the CRUD actions for Section model.
 */
class SectionController extends BaseController
{
    protected $googleFonts;

    public function init()
    {
        parent::init();
        include Yii::getAlias('@backend/web' . Yii::$app->params['template']['alias']['inc']) . '/customizer-library/extensions/fonts.php';
        $this->googleFonts = get_google_fonts();
    }

    protected function setModel()
    {
        $this->_model = new Section;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new SectionSearch;
    }

    // Use Standalone Actions
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'view' => ['class' => SectionViewAction::className() ],
        ]);
    }

    public function actionGoogleFontList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $out = [];
        foreach ($this->googleFonts as $gf => $f) {
            $out[] = ['value' => $gf];
        }

        return $out;
    }
}
