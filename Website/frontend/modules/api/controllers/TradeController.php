<?php

namespace frontend\modules\api\controllers;

use common\models\Trade;
use yii\rest\ActiveController;


class TradeController extends ActiveController
{
    public $modelClass = Trade::class;
}
