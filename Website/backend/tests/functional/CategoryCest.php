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
        // Visit the login page
        $I->amOnRoute('/site/login');
    }

    // Test for creating a category after logging in
    public function createCategory(FunctionalTester $I)
    {
        // Use credentials from fixture file (e.g., 'erau' and 'password_0')
        $I->fillField('input[name="LoginForm[username]"]', 'erau');
        $I->fillField('input[name="LoginForm[password]"]', 'password_0');
        $I->click('Sign In');  // Click the sign-in button

        // Check if login is successful
        $I->see('Reports'); // Check if logged in successfully

        // Now that the user is logged in, go to the create category page
        $I->amOnRoute('/category/create');
        $I->see('Create Category'); // Or other text that identifies the category creation page

        // Create a valid category
        $I->fillField('Category[name]', 'Tech Gadgets');
        $I->click('Save');  // Adjust button if necessary

        // Check if the category was created and that the user is redirected to the category view page
        $I->seeInCurrentUrl('/category/view');  // Adjust based on the actual URL that displays after category is created
        $I->see('Tech Gadgets');  // Check if the created category is displayed on the page
    }
}
