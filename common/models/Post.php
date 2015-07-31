<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;
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
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            ['class' => SluggableBehavior::className(), 'attribute' => 'title'],
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
