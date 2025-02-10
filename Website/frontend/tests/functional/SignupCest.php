<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\models\User;
use common\models\UserInfo;

class SignupCest
{
    protected $formId = '#form-signup';

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/signup');
    }

    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->see('Signup', 'h1');
        $I->submitForm($this->formId, []);

        $I->see('Username cannot be blank.', '.invalid-feedback');
        $I->see('Email cannot be blank.', '.invalid-feedback');
        $I->see('Password cannot be blank.', '.invalid-feedback');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'SignupForm[username]'  => 'tester',
            'SignupForm[email]'     => 'tester.email@example.com',
            'SignupForm[password]'  => 'tester_password',
            'SignupForm[name]'      => 'Tester User',
            'SignupForm[address]'   => 'Some address',
            'SignupForm[postal_code]' => '1234-576',
        ]);


        $I->seeRecord('common\models\User', [
            'username' => 'tester',
            'email' => 'tester.email@example.com',
        ]);

        $user = User::find()->where(['username' => 'tester'])->one();


        $I->seeEmailIsSent();
    }
}
