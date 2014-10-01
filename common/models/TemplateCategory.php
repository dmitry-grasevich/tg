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

    public static function getSample()
    {
        return
            [
                'Headers' => [
                    'id' => 1,
                    'items' => [
                        [ 'id' => 1, 'thumbnail' => 'header1.png' ],
                        [ 'id' => 2, 'thumbnail' => 'header2.png' ],
                        [ 'id' => 3, 'thumbnail' => 'header3.png' ],
                        [ 'id' => 4, 'thumbnail' => 'header4.png' ],
                        [ 'id' => 5, 'thumbnail' => 'header5.png' ],
                        [ 'id' => 6, 'thumbnail' => 'header6.png' ],
                        [ 'id' => 7, 'thumbnail' => 'header7.png' ],
                    ],
                ],
                'Content Sections' => [
                    'id' => 2,
                    'items' => [
                        [ 'id' => 1, 'thumbnail' => 'content_section1.png' ],
                        [ 'id' => 2, 'thumbnail' => 'content_section2.png' ],
                        [ 'id' => 3, 'thumbnail' => 'content_section3.png' ],
                        [ 'id' => 4, 'thumbnail' => 'content_section4.png' ],
                        [ 'id' => 5, 'thumbnail' => 'content_section5.png' ],
                        [ 'id' => 6, 'thumbnail' => 'content_section6.png' ],
                        [ 'id' => 7, 'thumbnail' => 'content_section7.png' ],
                        [ 'id' => 8, 'thumbnail' => 'content_section8.png' ],
                    ],
                ],
                'Dividers' => [
                    'id' => 3,
                    'items' => [
                        [ 'id' => 1, 'thumbnail' => 'divider1.png' ],
                        [ 'id' => 2, 'thumbnail' => 'divider2.png' ],
                        [ 'id' => 3, 'thumbnail' => 'divider3.png' ],
                        [ 'id' => 4, 'thumbnail' => 'divider4.png' ],
                        [ 'id' => 5, 'thumbnail' => 'divider5.png' ],
                    ],
                ],
                'Portfolios' => [
                    'id' => 4,
                    'items' => [
                        [ 'id' => 1, 'thumbnail' => 'portfolio1.png' ],
                        [ 'id' => 2, 'thumbnail' => 'portfolio2.png' ],
                        [ 'id' => 3, 'thumbnail' => 'portfolio3.png' ],
                    ],
                ],
                'Team' => [
                    'id' => 5,
                    'items' => [
                        [ 'id' => 1, 'thumbnail' => 'team1.png' ],
                        [ 'id' => 2, 'thumbnail' => 'team2.png' ],
                        [ 'id' => 3, 'thumbnail' => 'team3.png' ],
                    ],
                ],
                'Pricing Tables' => [
                    'id' => 6,
                    'items' => [
                        [ 'id' => 1, 'thumbnail' => 'pricing_table1.png' ],
                        [ 'id' => 2, 'thumbnail' => 'pricing_table2.png' ],
                        [ 'id' => 3, 'thumbnail' => 'pricing_table3.png' ],
                    ],
                ],
                'Contact' => [
                    'id' => 7,
                    'items' => [
                        [ 'id' => 1, 'thumbnail' => 'contact1.png' ],
                        [ 'id' => 2, 'thumbnail' => 'contact2.png' ],
                    ],
                ],
                'Footers' => [
                    'id' => 7,
                    'items' => [
                        [ 'id' => 1, 'thumbnail' => 'footer1.png' ],
                        [ 'id' => 2, 'thumbnail' => 'footer2.png' ],
                        [ 'id' => 2, 'thumbnail' => 'footer3.png' ],
                    ],
                ],
            ];
    }
}
