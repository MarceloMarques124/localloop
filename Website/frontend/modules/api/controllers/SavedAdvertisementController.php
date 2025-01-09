<?php

namespace frontend\modules\api\controllers;

use common\models\SavedAdvertisement;
use yii\rest\ActiveController;


class SavedAdvertisementController extends ActiveController
{
    public $modelClass = SavedAdvertisement::class;
}
