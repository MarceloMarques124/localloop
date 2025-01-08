<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnRoute(\Yii::$app->homeUrl);

        $I->see('Login');
        $I->see('Signup');


        $I->seeLink('Login');
        $I->seeLink('Signup');
    }
}
