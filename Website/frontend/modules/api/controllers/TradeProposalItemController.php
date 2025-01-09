<?php

namespace frontend\modules\api\controllers;

use common\models\TradeProposalItem;
use yii\rest\ActiveController;


class TradeProposalItemController extends ActiveController
{
    public $modelClass = TradeProposalItem::class;
}
