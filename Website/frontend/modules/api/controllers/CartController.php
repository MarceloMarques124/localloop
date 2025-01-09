<?php

namespace frontend\modules\api\controllers;

use common\models\Cart;
use yii\rest\ActiveController;


class CartController extends ActiveController
{
    public $modelClass = Cart::class;
}
