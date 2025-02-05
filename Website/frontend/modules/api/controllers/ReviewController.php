<?php

namespace frontend\modules\api\controllers;

use common\models\Review;
use yii\rest\ActiveController;


class ReportController extends ActiveController
{
    public $modelClass = Review::class;
}
