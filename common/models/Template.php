<?php

namespace common\models;

use kartik\helpers\Html;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "template".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $filename
 * @property string $directory
 * @property string $img
 * @property string $code
 *
 * @property TemplateCategory $category
 * @property TemplateCss[] $templateCsses
 * @property TemplateJs[] $templateJses
 * @property TemplateFunctions[] $templateFunctions
 * @property Csses[] $csses
 * @property Jses[] $jses
 * @property Functions[] $functions
 */
class Template extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'filename'], 'required'],
            [['category_id'], 'integer'],
            [['code'], 'string'],
            [['img'], 'file', 'types' => 'jpg,jpeg,gif,png'],
            [['name', 'filename', 'directory', 'img'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'name' => Yii::t('app', 'Name'),
            'filename' => Yii::t('app', 'Filename'),
            'directory' => Yii::t('app', 'Dir'),
            'img' => Yii::t('app', 'Img'),
            'code' => Yii::t('app', 'Code'),
            'categoryName' => Yii::t('app', 'Category'),
            'CssesName' => Yii::t('app', 'Css'),
            'JsesName' => Yii::t('app', 'Js'),
            'FunctionsName' => Yii::t('app', 'Functions'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(TemplateCategory::className(), ['id' => 'category_id']);
    }

    /**
     * Getter for category name
     *
     * @return string  category name
     */
    public function getCategoryName() {
        return $this->category->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateCsses()
    {
        return $this->hasMany(TemplateCss::className(), ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateJses()
    {
        return $this->hasMany(TemplateJs::className(), ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateFunctions()
    {
        return $this->hasMany(TemplateFunctions::className(), ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCsses()
    {
        return $this->hasMany(Css::className(), ['id' => 'css_id'])
            ->viaTable('template_css', ['template_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getCssesName()
    {
        if (!empty($this->csses)) {
            $names = [];
            foreach ($this->csses as $css) {
                $names[] = Html::a($css->name, ['/css/view', 'id' => $css->id]);
            }
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJses()
    {
        return $this->hasMany(Js::className(), ['id' => 'js_id'])
            ->viaTable('template_js', ['template_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getJsesName()
    {
        if (!empty($this->jses)) {
            $names = [];
            foreach ($this->jses as $js) {
                $names[] = Html::a($js->name, ['/js/view', 'id' => $js->id]);
            }
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunctions()
    {
        return $this->hasMany(Functions::className(), ['id' => 'functions_id'])
            ->viaTable('template_functions', ['template_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getFunctionsName()
    {
        if (!empty($this->functions)) {
            $names = [];
            foreach ($this->functions as $function) {
                $names[] = Html::a($function->name, ['/functions/view', 'id' => $function->id]);
            }
            return implode(', ', $names);
        }
        return '';
    }
}
