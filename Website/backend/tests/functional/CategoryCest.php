<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

class CategoryCest
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

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
    }

    public function createCategory(FunctionalTester $I)
    {
        $I->fillField('input[name="LoginForm[username]"]', 'erau');
        $I->fillField('input[name="LoginForm[password]"]', 'password_0');
        $I->click('Sign In');
        $I->see('Reports');

        $I->amOnRoute('/category/create');
        $I->see('Create Category');

        $I->fillField('Category[name]', 'Tech Gadgets');
        $I->click('Save');

        $I->seeInCurrentUrl('/category/view');
        $I->see('Tech Gadgets');
    }
}
