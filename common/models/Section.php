<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "section".
 *
 * @property integer $id
 * @property integer $template_id
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property integer $priority
 *
 * @property SectionControl[] $sectionControls
 * @property Template $template
 */
class Section extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'alias', 'title'], 'required'],
            [['template_id', 'priority'], 'integer'],
            [['description'], 'string'],
            [['alias', 'title'], 'string', 'max' => 255],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tg', 'ID'),
            'template_id' => Yii::t('tg', 'Template ID'),
            'alias' => Yii::t('tg', 'Alias'),
            'title' => Yii::t('tg', 'Title'),
            'description' => Yii::t('tg', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionControls()
    {
        return $this->hasMany(SectionControl::className(), ['section_id' => 'id'])->orderBy('section_control.priority');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getControls()
    {
        return $this->hasMany(Control::className(), ['id' => 'control_id'])->via('sectionControls');
    }

    /**
     * @param array $controls
     */
    public function setControls($controls)
    {
        $controls = empty($controls) ? [] : Control::findAll($controls);
        $this->populateRelation('controls', $controls);
    }

    /**
     * @return string
     */
    public function getControlsName()
    {
        if (!empty($this->controls)) {
            $names = [];
            $sectionControls = $this->getSectionControls()->all();
            foreach ($sectionControls as $sc) {
                /** @var SectionControl $sc */
                $n = $sc->control->name . ' (' . $sc->default . ')';
                $names[] = Html::a($n, ['/control/view', 'id' => $sc->control_id]);
            }
            return implode(',<br /> ', $names);
        }
        return '';
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $relatedRecords = $this->getRelatedRecords();
        foreach ($relatedRecords as $model => $data) {
            if (!is_array($data)) continue;
            $this->unlinkAll($model, true);
            if (!empty($data)) {
                foreach ($data as $relation) {
                    $this->link($model, $relation);
                }
            }
        }
    }
}
