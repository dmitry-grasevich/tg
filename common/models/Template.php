<?php

namespace common\models;

use Yii;
use kartik\helpers\Html;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;


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
 * @property integer $is_visible  show or not this template on frontend
 *
 * @property TemplateCategory $category
 * @property TemplateCss[] $templateCss
 * @property TemplateJs[] $templateJs
 * @property TemplateImage[] $templateImages
 * @property TemplateFunctions[] $templateFunctions
 * @property Css[] $css
 * @property Js[] $js
 * @property Image[] $images
 * @property Font[] $fonts
 * @property Plugin[] $plugins
 * @property Functions[] $functions
 * @property Template[] $children
 * @property Template[] $parents
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name'], 'required'],
            [['category_id', 'is_visible'], 'integer'],
            [['code', 'filename'], 'string'],
            [['img'], 'file', 'extensions' => 'jpg,jpeg,gif,png'],
            [['name', 'filename', 'directory', 'img'], 'string', 'max' => 255],
            // relations
            [['parents', 'children',  'css', 'js', 'images', 'fonts', 'functions', 'plugins'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category'),
            'name' => Yii::t('app', 'Name'),
            'filename' => Yii::t('app', 'Filename'),
            'directory' => Yii::t('app', 'Dir'),
            'img' => Yii::t('app', 'Img'),
            'code' => Yii::t('app', 'Code'),
            'categoryName' => Yii::t('app', 'Category'),
            'css' => Yii::t('app', 'Css'),
            'CssName' => Yii::t('app', 'Css'),
            'js' => Yii::t('app', 'Js'),
            'JsName' => Yii::t('app', 'Js'),
            'image' => Yii::t('app', 'Images'),
            'ImageName' => Yii::t('app', 'Images'),
            'font' => Yii::t('app', 'Fonts'),
            'FontName' => Yii::t('app', 'Fonts'),
            'plugin' => Yii::t('app', 'Plugins'),
            'PluginName' => Yii::t('app', 'Plugins'),
            'functions' => Yii::t('app', 'Functions'),
            'FunctionsName' => Yii::t('app', 'Functions'),
            'parentsName' => Yii::t('app', 'Parents'),
            'childrenName' => Yii::t('app', 'Children'),
            'is_visible' => Yii::t('app', 'Visible on Frontend'),
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
    public function getCategoryName()
    {
        return $this->category->name;
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $dir = Yii::getAlias('@webroot/images');
            FileHelper::createDirectory($dir);
            // TODO: create thumbnail image; check for an image with the same name existing
            $img = UploadedFile::getInstance($this, 'img');
            if (!empty($img)) {
                if ($img->saveAs($dir . '/' . $img->name)) {
                    $this->img = $img->name;
                } else {
                    return false;
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $relatedRecords = $this->getRelatedRecords();
        foreach ($relatedRecords as $model => $data) {
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
            'category' => function($query) {
                $query->where(['template_category.is_basic' => 0, 'template_category.is_visible' => 1]);
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
}
