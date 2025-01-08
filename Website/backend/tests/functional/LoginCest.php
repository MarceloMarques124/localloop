<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * Load fixtures before db transaction begins.
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }

    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I)
    {
        // Visit the login page
        $I->amOnRoute('/site/login');

        // Fill in the 'Username' and 'Password' fields
        $I->fillField('input[name="LoginForm[username]"]', 'erau');
        $I->fillField('input[name="LoginForm[password]"]', 'password_0');

        // Click the 'Sign In' button (find the button by its text content)
        $I->click('Sign In');

        // Assert that the user is redirected to a page showing 'Reports' button
        $I->see('Reports');

        // Assert that the links for login and signup are no longer visible
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
