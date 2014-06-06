<?php

namespace backend\controllers;

use Yii;
use common\models\Image;
use common\models\search\Image as ImageSearch;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new Image;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new ImageSearch;
    }
}
