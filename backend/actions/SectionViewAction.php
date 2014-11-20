<?php
namespace backend\actions;

use common\models\SectionControl;
use Yii;
use yii\base\ErrorException;

class SectionViewAction extends ViewAction
{
    public function run()
    {
        $id = intval(Yii::$app->request->get('id'));
        if (!$id) {
            throw new ErrorException('Model cannot be found');
        }
        $model = $this->controller->findModel($id);

        if ($priorities = Yii::$app->request->post('Priority')) {
            foreach ($priorities as $sectionControlId => $priority) {
                $sectionControl = SectionControl::findOne($sectionControlId);
                $sectionControl->priority = $priority;
                if (!$sectionControl->save()) {
                    return $this->controller->render('view', ['model' => $model]);
                }
            }
            return $this->controller->redirect(['view', 'id' => $model->id]);
        }

        if ($defaults = Yii::$app->request->post('Default')) {
            foreach ($defaults as $sectionControlId => $default) {
                $sectionControl = SectionControl::findOne($sectionControlId);
                $sectionControl->default = $default;
                if (!$sectionControl->save()) {
                    return $this->controller->render('view', ['model' => $model]);
                }
            }
            return $this->controller->redirect(['view', 'id' => $model->id]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->controller->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->controller->render('view', ['model' => $model]);
        }
    }
}