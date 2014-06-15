<?php

namespace common\models;

use kartik\helpers\Html;
use Yii;
use yii\helpers\ArrayHelper;
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
 * @property Functions[] $functions
 * @property Template[] $children
 * @property Template[] $parents
 */
class Template extends Library
{
    protected $relations = [
        'parents' => '\common\models\Template',
        'children' => '\common\models\Template',
        'css' => '\common\models\Css',
        'js' => '\common\models\Js',
        'images' => '\common\models\Image',
        'fonts' => '\common\models\Font',
        'functions' => '\common\models\Functions',
    ];

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
            [['category_id'], 'integer'],
            [['code', 'filename'], 'string'],
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
            'functions' => Yii::t('app', 'Functions'),
            'FunctionsName' => Yii::t('app', 'Functions'),
            'parentsName' => Yii::t('app', 'Parents'),
            'childrenName' => Yii::t('app', 'Children'),
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
        return $this->hasMany(Css::className(), ['id' => 'css_id'])
            ->viaTable('template_css', ['template_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getCssName()
    {
        if (!empty($this->css)) {
            $names = [];
            foreach ($this->css as $css) {
                $names[] = Html::a($css->name, ['/css/view', 'id' => $css->id]);
            }
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJs()
    {
        return $this->hasMany(Js::className(), ['id' => 'js_id'])
            ->viaTable('template_js', ['template_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getJsName()
    {
        if (!empty($this->js)) {
            $names = [];
            foreach ($this->js as $js) {
                $names[] = Html::a($js->name, ['/js/view', 'id' => $js->id]);
            }
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id' => 'image_id'])
            ->viaTable('template_image', ['template_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        if (!empty($this->images)) {
            $names = [];
            foreach ($this->images as $image) {
                $names[] = Html::a($image->name, ['/image/view', 'id' => $image->id]);
            }
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFonts()
    {
        return $this->hasMany(Font::className(), ['id' => 'font_id'])
            ->viaTable('template_font', ['template_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getFontName()
    {
        if (!empty($this->fonts)) {
            $names = [];
            foreach ($this->fonts as $font) {
                $names[] = Html::a($font->name, ['/font/view', 'id' => $font->id]);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Template::className(), ['id' => 'child_id'])
            ->viaTable('related_template', ['parent_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getChildrenName()
    {
        if (!empty($this->children)) {
            $names = [];
            foreach ($this->children as $child) {
                $names[] = Html::a($child->name, ['/template/view', 'id' => $child->id]);
            }
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(Template::className(), ['id' => 'parent_id'])
            ->viaTable('related_template', ['child_id' => 'id']);
    }


    /**
     * @return string
     */
    public function getParentsName()
    {
        if (!empty($this->parents)) {
            $names = [];
            foreach ($this->parents as $parent) {
                $names[] = Html::a($parent->name, ['/template/view', 'id' => $parent->id]);
            }
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
                $img->saveAs($dir . '/' . $img->name);
                $this->img = $img->name;
            }

            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert)
    {
        parent::afterSave($insert);

        if ($post = ArrayHelper::getValue($_POST, 'Template')) {
            foreach ($this->relations as $relation => $class) {
                if (isset($post[$relation])) {
                    $related = $class::findAll($post[$relation]);
                    $this->saveRelated($relation, $related);
                }
            }
        }
    }
}
