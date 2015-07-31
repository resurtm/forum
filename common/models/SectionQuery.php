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
        return $this->andWhere('section_id IS NULL');
    }

    /**
     * Adds condition which filters only non-root children sections.
     * @return SectionQuery
     */
    public function children()
    {
        return $this->andWhere('section_id IS NOT NULL');
    }
}
