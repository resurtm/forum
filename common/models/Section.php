<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * @property integer $id
 *
 * @property string $title
 * @property string $slug
 *
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property integer $section_id
 * @property Section $parent
 * @property Section[] $children
 *
 * @property string $url to this section.
 */
class Section extends ActiveRecord
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
    public function getParent()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Section::className(), ['section_id' => 'id'])->inverseOf('parent');
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new SectionQuery(get_called_class());
    }

    /**
     * Generates URL to this section.
     * @return string URL to this section.
     */
    public function getUrl()
    {
        if ($this->section_id === null) {
            return Url::toRoute(['section/view', 'id' => $this->id, 'slug' => $this->slug]);
        } else {
            return Url::toRoute(['section/view', 'parentId' => $this->parent->id, 'parentSlug' => $this->parent->slug,
                'id' => $this->id, 'slug' => $this->slug]);
        }
    }
}
