<?php

namespace backend\models;

use Yii;
use yii\db\ActiveQuery;

class CharityQuery extends ActiveQuery
{
    public function scopeByUserBranch()
    {
        return $this->andWhere(['branch_code' => Yii::$app->user->identity->code]);
    }

    public function scopeByTypeManually()
    {
        return $this->andWhere(['type' => Charity::CHARITY_TYPE_MANUALLY]);
    }

    public function byTypeAutomatic()
    {
        return $this->andWhere(['type' => Charity::CHARITY_TYPE_AUTOMATIC]);
    }
}