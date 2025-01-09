<?php

namespace frontend\modules\api\controllers;

use common\models\Report;
use yii\rest\ActiveController;


class ReportController extends ActiveController
{
    public $modelClass = Report::class;
}
