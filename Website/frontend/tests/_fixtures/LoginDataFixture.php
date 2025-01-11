<?php

namespace frontend\tests\fixtures;

use yii\test\ActiveFixture;

class LoginDataFixture extends ActiveFixture
{
    public $modelClass = 'common\models\User';
    public $dataFile = '@frontend/tests/_data/login_data.php';
}
