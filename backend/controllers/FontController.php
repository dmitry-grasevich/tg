<?php

namespace backend\controllers;

use Yii;
use common\models\Font;
use common\models\search\Font as FontSearch;

/**
 * FontController implements the CRUD actions for Font model.
 */
class FontController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new Font;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new FontSearch;
    }
}
