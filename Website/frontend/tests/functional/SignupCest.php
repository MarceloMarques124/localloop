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

        // Verify validation error messages for required fields
        $I->see('Username cannot be blank.', '.invalid-feedback');
        $I->see('Email cannot be blank.', '.invalid-feedback');
        $I->see('Password cannot be blank.', '.invalid-feedback');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        // Adjust postal code format to match your validation pattern
        $I->submitForm($this->formId, [
            'SignupForm[username]'  => 'tester',
            'SignupForm[email]'     => 'tester.email@example.com',
            'SignupForm[password]'  => 'tester_password',
            'SignupForm[name]'      => 'Tester User',
            'SignupForm[address]'   => 'Some address',
            'SignupForm[postal_code]' => '1234-576',  // Ensure validation or format matches
        ]);


        $I->seeRecord('common\models\User', [
            'username' => 'tester',
            'email' => 'tester.email@example.com',
        ]);

        $user = User::find()->where(['username' => 'tester'])->one();
        $I->assertNotEmpty($user->password_hash); // Password should be hashed

        $I->seeRecord(UserInfo::class, [
            'name'       => 'Tester User',
            'address'    => 'Some address',
            'postal_code' => '1234-576',
            'id'         => $user->id,  // Check that userInfo matches the user's ID
        ]);

        $I->seeEmailIsSent();
    }
}
