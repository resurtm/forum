<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
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
        return $this->hasMany(Section::className(), ['section_id' => 'id']);
    }
}
