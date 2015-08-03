<?php

namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\FileHelper;
use yii\behaviors\TimestampBehavior;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use common\helpers\ImageTg;

/**
 * This is the model class for table "template".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $img
 * @property string $code
 * @property boolean $is_visible
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property string $updated_at
 *
 * @property Category $category
 * @property Section[] $sections
 * @property TemplateCss[] $templateCss
 * @property TemplateJs[] $templateJs
 * @property TemplateImage[] $templateImages
 * @property TemplateFunctions[] $templateFunctions
 * @property TemplateElement[] $templateElements
 * @property Css[] $css
 * @property Js[] $js
 * @property Image[] $images
 * @property Font[] $fonts
 * @property Plugin[] $plugins
 * @property Functions[] $functions
 * @property Template[] $children
 * @property Template[] $parents
 * @property Element[] $elements
 */
class Template extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'alias', 'title'], 'required'],
            [['category_id', 'is_visible', 'updated_at'], 'integer'],
            [['code', 'description'], 'string'],
            [['name', 'img', 'alias', 'title'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            // relations
            [['parents', 'children', 'css', 'js', 'images', 'fonts', 'functions', 'plugins', 'elements', 'sections'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tg', 'ID'),
            'category_id' => Yii::t('tg', 'Category'),
            'name' => Yii::t('tg', 'Name'),
            'alias' => Yii::t('tg', 'Alias'),
            'title' => Yii::t('tg', 'Title'),
            'description' => Yii::t('tg', 'Description'),
            'img' => Yii::t('tg', 'Preview Image'),
            'code' => Yii::t('tg', 'Code'),

            'categoryName' => Yii::t('tg', 'Category'),
            'css' => Yii::t('tg', 'CSS'),
            'CssName' => Yii::t('tg', 'CSS'),
            'js' => Yii::t('tg', 'JS'),
            'JsName' => Yii::t('tg', 'JS'),
            'elements' => Yii::t('tg', 'Elements'),
            'ElementsName' => Yii::t('tg', 'Elements'),
            'image' => Yii::t('tg', 'Images'),
            'ImageName' => Yii::t('tg', 'Images'),
            'font' => Yii::t('tg', 'Fonts'),
            'FontName' => Yii::t('tg', 'Fonts'),
            'plugin' => Yii::t('tg', 'Plugins'),
            'PluginName' => Yii::t('tg', 'Plugins'),
            'functions' => Yii::t('tg', 'Functions'),
            'FunctionsName' => Yii::t('tg', 'Functions'),
            'parentsName' => Yii::t('tg', 'Parents'),
            'childrenName' => Yii::t('tg', 'Children'),
            'is_visible' => Yii::t('tg', 'Visible on Frontend'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Getter for category name
     *
     * @return string  category name
     */
    public function getCategoryName()
    {
        return $this->category->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::className(), ['template_id' => 'id'])->orderBy('section.priority');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateCss()
    {
        return $this->hasMany(TemplateCss::className(), ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateJs()
    {
        return $this->hasMany(TemplateJs::className(), ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateImages()
    {
        return $this->hasMany(TemplateImage::className(), ['template_id' => 'id']);
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
    public function getCss()
    {
        return $this->hasMany(Css::className(), ['id' => 'css_id'])->viaTable('template_css', ['template_id' => 'id']);
    }

    /**
     * @param array $css
     */
    public function setCss($css)
    {
        $css = empty($css) ? [] : Css::findAll($css);
        $this->populateRelation('css', $css);
    }

    /**
     * @return string
     */
    public function getCssName()
    {
        if (!empty($this->css)) {
            $names = [];
            foreach ($this->css as $css)
                $names[] = Html::a($css->name, ['/css/view', 'id' => $css->id]);
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJs()
    {
        return $this->hasMany(Js::className(), ['id' => 'js_id'])->viaTable('template_js', ['template_id' => 'id']);
    }

    /**
     * @param array $js
     */
    public function setJs($js)
    {
        $js = empty($js) ? [] : Js::findAll($js);
        $this->populateRelation('js', $js);
    }

    /**
     * @return string
     */
    public function getJsName()
    {
        if (!empty($this->js)) {
            $names = [];
            foreach ($this->js as $js)
                $names[] = Html::a($js->name, ['/js/view', 'id' => $js->id]);
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id' => 'image_id'])->viaTable('template_image', ['template_id' => 'id']);
    }

    /**
     * @param array $images
     */
    public function setImages($images)
    {
        $images = empty($images) ? [] : Image::findAll($images);
        $this->populateRelation('images', $images);
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        if (!empty($this->images)) {
            $names = [];
            foreach ($this->images as $image)
                $names[] = Html::a($image->name, ['/image/view', 'id' => $image->id]);
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFonts()
    {
        return $this->hasMany(Font::className(), ['id' => 'font_id'])->viaTable('template_font', ['template_id' => 'id']);
    }

    /**
     * @param array $fonts
     */
    public function setFonts($fonts)
    {
        $fonts = empty($fonts) ? [] : Font::findAll($fonts);
        $this->populateRelation('fonts', $fonts);
    }

    /**
     * @return string
     */
    public function getFontName()
    {
        if (!empty($this->fonts)) {
            $names = [];
            foreach ($this->fonts as $font)
                $names[] = Html::a($font->name, ['/font/view', 'id' => $font->id]);
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlugins()
    {
        return $this->hasMany(Plugin::className(), ['id' => 'plugin_id'])->viaTable('template_plugin', ['template_id' => 'id']);
    }

    /**
     * @param array $plugins
     */
    public function setPlugins($plugins)
    {
        $plugins = empty($plugins) ? [] : Plugin::findAll($plugins);
        $this->populateRelation('plugins', $plugins);
    }

    /**
     * @return string
     */
    public function getPluginName()
    {
        if (!empty($this->plugins)) {
            $names = [];
            foreach ($this->plugins as $plugin)
                $names[] = Html::a($plugin->name, ['/plugin/view', 'id' => $plugin->id]);
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunctions()
    {
        return $this->hasMany(Functions::className(), ['id' => 'functions_id'])->viaTable('template_functions', ['template_id' => 'id']);
    }

    /**
     * @param array $functions
     */
    public function setFunctions($functions)
    {
        $functions = empty($functions) ? [] : Functions::findAll($functions);
        $this->populateRelation('functions', $functions);
    }

    /**
     * @return string
     */
    public function getFunctionsName()
    {
        if (!empty($this->functions)) {
            $names = [];
            foreach ($this->functions as $function)
                $names[] = Html::a($function->name, ['/functions/view', 'id' => $function->id]);
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Template::className(), ['id' => 'child_id'])->viaTable('related_template', ['parent_id' => 'id']);
    }

    /**
     * @param array $children
     */
    public function setChildren($children)
    {
        $children = empty($children) ? [] : Template::findAll($children);
        $this->populateRelation('children', $children);
    }

    /**
     * @return string
     */
    public function getChildrenName()
    {
        if (!empty($this->children)) {
            $names = [];
            foreach ($this->children as $child)
                $names[] = Html::a($child->name, ['/template/view', 'id' => $child->id]);
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(Template::className(), ['id' => 'parent_id'])->viaTable('related_template', ['child_id' => 'id']);
    }

    /**
     * @param array $parents
     */
    public function setParents($parents)
    {
        $parents = empty($parents) ? [] : Template::findAll($parents);
        $this->populateRelation('parents', $parents);
    }

    /**
     * @return string
     */
    public function getParentsName()
    {
        if (!empty($this->parents)) {
            $names = [];
            foreach ($this->parents as $parent)
                $names[] = Html::a($parent->name, ['/template/view', 'id' => $parent->id]);
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElements()
    {
        return $this->hasMany(Element::className(), ['id' => 'element_id'])->viaTable('template_element', ['template_id' => 'id']);
    }

    /**
     * @param array $elements
     */
    public function setElements($elements)
    {
        $elements = empty($elements) ? [] : Element::findAll($elements);
        $this->populateRelation('elements', $elements);
    }

    /**
     * @return string
     */
    public function getElementsName()
    {
        if (!empty($this->elements)) {
            $names = [];
            foreach ($this->elements as $element)
                $names[] = Html::a($element->name, ['/element/view', 'id' => $element->id]);
            return implode(', ', $names);
        }
        return '';
    }

    public static function getCustomizerControls($id)
    {
        $template = Template::find()
            ->select(['{{template}}.id', 'updated_at'])
            ->where('template.id = :id', [':id' => $id])
            ->joinWith('sections.sectionControls.control')
            ->asArray()
            ->all();

        return $template[0];
    }

    /**
     * @param bool|false $isBackend
     * @param bool|false $isThumb
     * @return bool|string
     */
    public function getImageDir($isBackend = false, $isThumb = false)
    {
        return Yii::getAlias('@' . ($isBackend ? 'backend' : 'frontend') . '/web/images/elements/' .
            $this->category->alias . ($isThumb ? '/thumbs' : ''));
    }

    /**
     * @param bool|false $isThumb
     * @return bool|string
     */
    public function getImagePath($isThumb = false)
    {
        return Yii::getAlias('@web/images/elements/' . $this->category->alias . ($isThumb ? '/thumbs' : ''));
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $img = UploadedFile::getInstance($this, 'img');
            if (!empty($img)) {
                $backendDir = Yii::getAlias('@webroot/images');
                $backendFullImagesDir = $this->getImageDir(true);
                $backendThumbsImagesDir = $this->getImageDir(true, true);
                $frontendFullImagesDir = $this->getImageDir();
                $frontendThumbsImagesDir = $this->getImageDir(false, true);
                FileHelper::createDirectory($backendDir);
                FileHelper::createDirectory($backendFullImagesDir);
                FileHelper::createDirectory($backendThumbsImagesDir);
                FileHelper::createDirectory($frontendFullImagesDir);
                FileHelper::createDirectory($frontendThumbsImagesDir);

                if (!$img->saveAs($backendDir . '/' . $img->name)) {
                    return false;
                }
                ImageTg::thumbnail($backendDir . '/' . $img->name, $backendFullImagesDir . '/' . $img->name,
                    1200, 2000, ['quality' => 80]);
                ImageTg::thumbnail($backendDir . '/' . $img->name, $backendThumbsImagesDir . '/' . $img->name,
                    272, 500, ['quality' => 80]);
                ImageTg::thumbnail($backendDir . '/' . $img->name, $frontendFullImagesDir . '/' . $img->name,
                    1200, 2000, ['quality' => 80]);
                ImageTg::thumbnail($backendDir . '/' . $img->name, $frontendThumbsImagesDir . '/' . $img->name,
                    272, 500, ['quality' => 80]);

                unlink($backendDir . '/' . $img->name);
                $this->img = $img->name;
            } elseif (!$this->getIsNewRecord()) {
                $this->img = $this->getOldAttribute('img');
            }
            return true;
        } else {
            return false;
        }
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

    /**
     * @param $t
     * @return array
     */
    public static function getSelected($t)
    {
        $result = [];
        $templates = [];
        $ts = explode('-', $t);
        foreach (self::find()->innerJoinWith([
            'category' => function ($query) {
                $query->where(['category.is_basic' => 0, 'category.is_visible' => 1]);
            }
        ])->where(['template.id' => $ts])->each() as $template) {
            if (in_array($template->id, $ts)) {
                $templates[$template->id] = $template;
            }
        }

        foreach ($ts as $selectedId) {
            if (array_key_exists($selectedId, $templates)) {
                $result[] = $templates[$selectedId];
            }
        }
        return $result;
    }

    /**
     * @param $data
     * @return bool
     */
    public function saveCustomizer($data)
    {
        $errors = [];
        $sections = [];
        $controls = [];
        foreach ($data as $sectionUid => $sectionData) {
            if (array_key_exists('controls', $sectionData) && count($sectionData['controls'])) {
                $sectionControls = $sectionData['controls'];
                foreach ($sectionControls as $controlUid => $controlData) {
                    $control = isset($controlData['id']) ? SectionControl::findOne($controlData['id']) :
                        new SectionControl(['scenario' => 'without_section']);
                    $control->attributes = $controlData;
                    if (!$control->validate()) {
                        $errors['control'][$controlUid] = $control->getErrors();
                    } else {
                        $controls[$sectionUid][] = $control;
                    }
                }
                unset($sectionData['controls']);
            }
            $section = isset($sectionData['id']) ? Section::findOne($sectionData['id']) :
                new Section();
            $section->attributes = $sectionData;
            $section->template_id = $this->id;
            if (!$section->validate()) {
                $errors['section'][$sectionUid] = $section->getErrors();
            } else {
                $sections[$sectionUid] = $section;
            }
        }

        if (empty($errors)) {
            foreach ($sections as $id => $section) {
                /** @var Section $section */
                $section->save(false);

                if (!array_key_exists($id, $controls)) {
                    continue;
                }

                foreach ($controls[$id] as $control) {
                    /** @var SectionControl $control */
                    $control->scenario = 'default';
                    $control->link('section', $section);
                    $control->save(false);
                }
            }
        } else {
            return $errors;
        }

        return true;
    }
}
