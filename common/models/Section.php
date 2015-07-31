<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\data\ActiveDataProvider;
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
 * @property Post[] $posts
 *
 * @property string $url to this section.
 */
class Section extends ActiveRecord
{
    /**
     * @var integer
     */
    public $postCount;

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
     * @return ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['section_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new SectionQuery(get_called_class());
    }

    public static function findRoots()
    {
        /** @var Section[] $sections */
        $sections = static::find()
            ->with([
                'children' => function ($q) { $q->indexBy('id'); },
            ])
            ->where(['section_id' => null])
            ->orderBy('title')
            ->all();

        $ids = [];
        foreach ($sections as $section) {
            $ids = array_merge($ids, array_keys($section->children));
        }

        $query = new Query();
        $counts = $query->select('COUNT(id)')
            ->from(Post::tableName())
            ->where(['section_id' => $ids])
            ->groupBy('section_id')
            ->indexBy('section_id')
            ->column(static::getDb());

        foreach ($sections as $section) {
            $section->postCount = 0;
            foreach ($section->children as $id => $child) {
                $child->postCount = isset($counts[$id]) ? $counts[$id] : 0;
                $section->postCount += $child->postCount;
            }
        }

        return $sections;
    }

    public function findPosts()
    {
        return new ActiveDataProvider([
            'query' => Post::find()->where(['section_id' => $this->id]),
            'pagination' => ['pageSize' => 12],
        ]);
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
