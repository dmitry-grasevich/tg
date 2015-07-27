<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "element".
 *
 * @property integer $id
 * @property integer $section_id
 * @property string $name
 * @property string $description
 * @property integer $priority
 * @property string $css_selector
 * @property string $identificator
 *
 * @property TemplateElement[] $templateElement
 * @property Section $section
 * @property Template[] $templates
 */
class Element extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'element';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'section_id', 'css_selector'], 'required'],
            [['priority', 'section_id', 'id'], 'integer'],
            [['description', 'css_selector', 'identificator'], 'string'],
            [['identificator'], 'unique'],
            // relations
            [['templates'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tg', 'ID'),
            'name' => Yii::t('tg', 'Name'),
            'description' => Yii::t('tg', 'Description'),
            'section_id' => Yii::t('tg', 'Section'),
            'priority' => Yii::t('tg', 'Priority'),
            'css_selector' => Yii::t('tg', 'CSS Selectors'),
            'identificator' => Yii::t('tg', 'Identificator'),
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
     * Getter for section name
     *
     * @return string  section name
     */
    public function getSectionName()
    {
        return $this->section->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['id' => 'template_id'])->viaTable('template_element', ['element_id' => 'id']);
    }

    /**
     * Generate section code
     *
     * @param string $panelId
     *
     * @return string
     */
    public function getSectionCode($panelId)
    {
        $section = $this->section;
        $code = str_replace('{{section_id}}', $this->identificator . '_section', $section->code);
        $code = str_replace('{{title}}', $this->name, $code);
        $code = str_replace('{{priority}}', $this->priority, $code);
        $code = str_replace('{{panel_id}}', $panelId, $code);
        $code = str_replace('{{description}}', $this->description, $code);
        $code .= "\n";

        $sectionControls = $section->getSectionControls()->all();
        foreach ($sectionControls as $sc) {
            /** @var SectionControl $sc */
            $control = $sc->control;
            $controlCode = str_replace('{{id}}', $this->identificator, $control->code);
            $controlCode = str_replace('{{label}}', $control->name, $controlCode);
            $controlCode = str_replace('{{section}}', $this->identificator . '_section', $controlCode);
            $controlCode = str_replace('{{priority}}', $sc->priority, $controlCode);
            $controlCode = str_replace('{{default}}', $sc->default, $controlCode);
            $controlCode .= "\n";
            $code .= $controlCode;
        }

        return $code;
    }

    /**
     * Generate mod code
     *
     * @param $panelId
     *
     * @return string
     */
    public function getModCode($panelId)
    {
        $controls = $this->section->controls;
        $function = '';

        foreach ($controls as $control) {
            if ($control->name == 'Font') {
                $function .= "\n\n" . 'add_action("wp_enqueue_scripts", "' . $panelId . '_' . $this->identificator .  '_font");
';
                $function .= 'function ' . $panelId . '_' . $this->identificator .  '_font()
{
    $fonts = array(
        get_theme_mod("' . $this->identificator . '-font", customizer_library_get_default("' . $this->identificator . '-font")),
    );

    $font_uri = customizer_library_get_google_font_uri($fonts);

    // Load Google Fonts
    wp_enqueue_style("' . $panelId . '_' . $this->identificator .  '_font", $font_uri, array(), null, "screen");

}
';
            }
        }

        return $function;
    }

    /**
     * Generate styles code
     *
     * @param $panelId
     *
     * @return string
     */
    public function getStyleCode($panelId)
    {
        $function = "\n\n" . 'add_action("customizer_library_styles", "' . $panelId . '_' . $this->identificator .  '_styles");
';
        $function .= 'function ' . $panelId . '_' . $this->identificator .  '_styles()
{
';

        $sectionControls = $this->section->getSectionControls()->all();
        foreach ($sectionControls as $sc) {
            /** @var SectionControl $sc */
            $control = $sc->control;
            if (!empty($control->styles_code)) {
                $code = str_replace('{{id}}', $this->identificator, $control->styles_code);
                $code = str_replace('{{selectors}}', $this->css_selector, $code);
                $function .= $code;
            }
        }
        $function .= '}
';

        return $function;
    }
}
