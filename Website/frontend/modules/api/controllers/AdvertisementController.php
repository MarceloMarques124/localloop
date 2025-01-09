<?php

namespace frontend\modules\api\controllers;

use common\models\Advertisement;
use yii\rest\ActiveController;


class AdvertisementController extends ActiveController
{
    public $modelClass = Advertisement::class;
}
