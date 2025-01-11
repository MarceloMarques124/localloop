<?php

namespace frontend\modules\api\controllers;

use common\models\UserInfo;
use yii\rest\ActiveController;


class UserController extends ActiveController
{
    public $modelClass = UserInfo::class;
}
