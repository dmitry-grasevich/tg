<?php
namespace backend\actions;

use Yii;
use yii\base\ErrorException;
use yii\web\NotFoundHttpException;
use common\models\Template;

class TemplateViewAction extends ViewAction
{
    public function run()
    {
        /** @var string $id   template id */
        $id = intval(Yii::$app->request->get('id'));
        if (!$id) {
            throw new NotFoundHttpException('Page not fount');
        }

        /** @var \common\models\Template $template */
        $template = Template::find()->where(['id' => $id])->with('images')->one();

        return $this->controller->render('view', [
            'template' => $template,
        ]);
    }
}