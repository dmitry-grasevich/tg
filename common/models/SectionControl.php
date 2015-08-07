<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "section_control".
 *
 * @property integer $id
 * @property integer $section_id
 * @property integer $control_id
 * @property integer $priority
 * @property string $alias
 * @property string $label
 * @property string $help
 * @property string $description
 * @property string $default
 * @property string $style
 * @property string $params
 * @property string $pseudojs
 *
 * @property Section $section
 * @property Control $control
 */
class SectionControl extends ActiveRecord
{
    const SCENARIO_WITHOUT_SECTION = 'without_section';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section_control';
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_WITHOUT_SECTION] = ['control_id', 'alias', 'label', 'priority', 'description', 'default', 'style', 'params', 'pseudojs', 'help'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'control_id', 'alias', 'label'], 'required'],
            [['control_id', 'alias', 'label'], 'required', 'on' => self::SCENARIO_WITHOUT_SECTION],
            [['section_id', 'control_id', 'priority'], 'integer'],
            [['description', 'default', 'style', 'params', 'pseudojs'], 'string'],
            [['alias', 'label', 'help'], 'string', 'max' => 255],
            [['control_id'], 'exist', 'skipOnError' => true, 'targetClass' => Control::className(), 'targetAttribute' => ['control_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tg', 'ID'),
            'section_id' => Yii::t('tg', 'Section ID'),
            'control_id' => Yii::t('tg', 'Control ID'),
            'priority' => Yii::t('tg', 'Priority'),
            'alias' => Yii::t('tg', 'Alias'),
            'label' => Yii::t('tg', 'Label'),
            'help' => Yii::t('tg', 'Help'),
            'description' => Yii::t('tg', 'Description'),
            'default' => Yii::t('tg', 'Default'),
            'style' => Yii::t('tg', 'Style'),
            'params' => Yii::t('tg', 'Params'),
            'pseudojs' => Yii::t('tg', 'Pseudo JS'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getControl()
    {
        return $this->hasOne(Control::className(), ['id' => 'control_id']);
    }

    /**
     * @param string $sectionAlias
     * @return string
     */
    public function getCodeForConfig($sectionAlias)
    {
        $control = $this->control;

        $code = "
                'tg-" . $sectionAlias . "-" . $this->alias . "' => array(
                    'type' => '" . $control->type . "',
                    'default' => " . $this->default . ",
                    'label' => __('" . $this->label . "', 'tg'),\n";

        if (!empty($this->description)) {
            $code .= "                    'description' => __('" . $this->description . "', 'tg'),\n";
        }

        if (!empty($this->help)) {
            $code .= "                    'help' => __('" . $this->help . "', 'tg'),\n";
        }

        if (!empty($this->params)) {
            $code .= "                    " . $this->params . "\n";
        }

        $code .= "                ),\n";

        return $code;
    }

    /**
     * @param string $sectionAlias
     * @return string
     */
    public function getStylesForConfig($sectionAlias)
    {
        return "'tg-" . $sectionAlias . "-" . $this->alias . "' => array(
                " . $this->style . "
             ),
             ";
    }

    /**
     * @param string $sectionAlias
     * @return string
     */
    public function getPseudoJsForConfig($sectionAlias)
    {
        return "'tg-" . $sectionAlias . "-" . $this->alias . "' => array(
                " . $this->pseudojs . "
            ),
            ";
    }
}
