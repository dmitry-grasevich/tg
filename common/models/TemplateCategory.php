<?php

namespace common\models;

use Yii;
use common\models\Library;

/**
 * This is the model class for table "template_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_basic
 * @property integer $is_visible  show or not this category items on frontend
 *
 * @property Template[] $templates
 */
class TemplateCategory extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_basic', 'is_visible'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'is_basic' => Yii::t('app', 'Basic Category'),
            'is_visible' => Yii::t('app', 'Visible on Frontend'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['category_id' => 'id']);
    }

    /**
     * Sample data
     *
     * @return array
     */
    public static function getSample()
    {
        return [
            'Headers' => [
                'id' => 1,
                'items' => [
                    [ 'id' => 4, 'img' => 'header1.png' ],
                    [ 'id' => 5, 'img' => 'header2.png' ],
                    [ 'id' => 1, 'img' => 'header3.png' ],
                    [ 'id' => 4, 'img' => 'header4.png' ],
                    [ 'id' => 5, 'img' => 'header5.png' ],
                    [ 'id' => 6, 'img' => 'header6.png' ],
                    [ 'id' => 7, 'img' => 'header7.png' ],
                ],
            ],
            'Content Sections' => [
                'id' => 2,
                'items' => [
                    [ 'id' => 8, 'img' => 'content_section1.png' ],
                    [ 'id' => 9, 'img' => 'content_section2.png' ],
                    [ 'id' => 10, 'img' => 'content_section3.png' ],
                    [ 'id' => 11, 'img' => 'content_section4.png' ],
                    [ 'id' => 12, 'img' => 'content_section5.png' ],
                    [ 'id' => 13, 'img' => 'content_section6.png' ],
                    [ 'id' => 14, 'img' => 'content_section7.png' ],
                    [ 'id' => 15, 'img' => 'content_section8.png' ],
                ],
            ],
            'Dividers' => [
                'id' => 3,
                'items' => [
                    [ 'id' => 16, 'img' => 'divider1.png' ],
                    [ 'id' => 17, 'img' => 'divider2.png' ],
                    [ 'id' => 18, 'img' => 'divider3.png' ],
                    [ 'id' => 19, 'img' => 'divider4.png' ],
                    [ 'id' => 20, 'img' => 'divider5.png' ],
                ],
            ],
            'Portfolios' => [
                'id' => 4,
                'items' => [
                    [ 'id' => 12, 'img' => 'portfolio1.png' ],
                    [ 'id' => 22, 'img' => 'portfolio2.png' ],
                    [ 'id' => 23, 'img' => 'portfolio3.png' ],
                ],
            ],
            'Team' => [
                'id' => 5,
                'items' => [
                    [ 'id' => 24, 'img' => 'team1.png' ],
                    [ 'id' => 25, 'img' => 'team2.png' ],
                    [ 'id' => 26, 'img' => 'team3.png' ],
                ],
            ],
            'Pricing Tables' => [
                'id' => 6,
                'items' => [
                    [ 'id' => 27, 'img' => 'pricing_table1.png' ],
                    [ 'id' => 28, 'img' => 'pricing_table2.png' ],
                    [ 'id' => 29, 'img' => 'pricing_table3.png' ],
                ],
            ],
            'Contact' => [
                'id' => 7,
                'items' => [
                    [ 'id' => 30, 'img' => 'contact1.png' ],
                    [ 'id' => 31, 'img' => 'contact2.png' ],
                ],
            ],
            'Footers' => [
                'id' => 7,
                'items' => [
                    [ 'id' => 32, 'img' => 'footer1.png' ],
                    [ 'id' => 33, 'img' => 'footer2.png' ],
                    [ 'id' => 34, 'img' => 'footer3.png' ],
                ],
            ],
        ];
    }
}
