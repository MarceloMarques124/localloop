<?php

namespace frontend\modules\api\controllers;

use common\models\CartItem;
use yii\rest\ActiveController;


class CartItemController extends ActiveController
{
    public $modelClass = CartItem::class;
}
