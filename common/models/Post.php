<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * @property integer $id
 *
 * @property integer $author_id
 * @property User $author
 *
 * @property integer $section_id
 * @property Section $section
 *
 * @property string $title
 * @property string $slug
 * @property string $text
 *
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property string $url to this post.
 */
class Post extends ActiveRecord
{
    /**
     * @var integer
     */
    public $rootSectionId;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            ['class' => BlameableBehavior::className(), 'createdByAttribute' => 'author_id', 'updatedByAttribute' => false],
            ['class' => SluggableBehavior::className(), 'attribute' => 'title'],
        ];
    }

    public function rules()
    {
        return [
            ['title', 'filter', 'filter' => 'trim'],
            ['title', 'required'],
            ['title', 'string', 'min' => 5, 'max' => 100],
            ['title', 'unique', 'message' => 'Post with this title already exists.'],

            ['text', 'filter', 'filter' => 'trim'],
            ['text', 'required'],
            ['text', 'string', 'min' => 10, 'max' => 10000],

            ['rootSectionId', 'required'],
            ['rootSectionId', 'exist', 'targetClass' => Section::className(), 'targetAttribute' => 'id'],

            ['section_id', 'required'],
            ['section_id', 'exist', 'targetClass' => Section::className(), 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    /**
     * Generates URL to this post.
     * @return string URL to this post.
     */
    public function getUrl()
    {
        return Url::toRoute([
            'post/view',
            'parentSectionId' => $this->section->parent->id, 'parentSectionSlug' => $this->section->parent->slug,
            'childSectionId' => $this->section->id, 'childSectionSlug' => $this->section->slug,
            'id' => $this->id, 'slug' => $this->slug,
        ]);
    }
}
