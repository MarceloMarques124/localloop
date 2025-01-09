<?php

namespace frontend\modules\api\controllers;

use common\models\TradeProposal;
use yii\rest\ActiveController;


class TradeProposalController extends ActiveController
{
    public $modelClass = TradeProposal::class;
}
