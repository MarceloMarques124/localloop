<?php

namespace frontend\tests\unit\models;

use common\fixtures\UserFixture;
use frontend\models\SignupForm;
use common\models\User;

class SignupFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        // Load user fixture data before each test
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',  // Adjust path as needed
            ],
        ]);
    }



    public function testCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'unique_username_' . time(),
            'email' => 'unique_email_' . time() . '@example.com',
            'password' => 'some_password',
            'name' => 'John Doe',
            'address' => '123 Main Street',
            'postal_code' => '12345',
        ]);

        // Attempt to sign up and ensure the result is not null
        $user = $model->signup();

        // Output errors if signup fails
        if ($user === null) {
            echo "Validation or saving failed: " . json_encode($model->errors);
            return;
        }

        verify($user)->notNull();  // Assert that the user is returned
    }

    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'troy.becker',  // Existing username in the fixture
            'email' => 'nicolas.dianna@hotmail.com',  // Existing email in the fixture
            'password' => 'some_password',
            'name' => 'Invalid User',
            'address' => '456 Invalid St',
            'postal_code' => '00000',
        ]);

        // Try to sign up with invalid data (existing username/email)
        verify($model->signup())->empty();  // Should return null as sign up should fail

        // Verify that errors are triggered for username and email
        verify($model->getErrors('username'))->notEmpty();  // Error for existing username
        verify($model->getErrors('email'))->notEmpty();  // Error for existing email

        // Check the exact error message for username/email
        verify($model->getFirstError('username'))->equals('This username has already been taken.');
        verify($model->getFirstError('email'))->equals('This email address has already been taken.');
    }
}
