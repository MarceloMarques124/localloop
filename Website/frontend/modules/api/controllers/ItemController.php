<?php

namespace frontend\modules\api\controllers;

use common\models\Item;
use yii\rest\ActiveController;


class ItemController extends ActiveController
{
    public $modelClass = Item::class;
}
