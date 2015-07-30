<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Enhanced active query class related to sections.
 */
class SectionQuery extends ActiveQuery
{
    /**
     * Adds condition which filters only root sections.
     * @return SectionQuery
     */
    public function roots()
    {
        return $this->andWhere(['section_id' => null]);
    }
}
