<?php

namespace frontend\tests\unit;

use common\models\Advertisement;
use common\models\UserInfo;
use yii\db\Exception;

class AdvertisementTest extends \Codeception\Test\Unit
{
    protected $tester;
    protected $userInfo;

    // Setup UserInfo data before running tests
    protected function _before()
    {
        $this->userInfo = UserInfo::find()->one(); // Fetch an existing user_info or create one
        if (!$this->userInfo) {
            $this->userInfo = new UserInfo([
                'name' => 'Test User',
                'address' => 'Test Address',
                'postal_code' => '12345678',
                'flagged_for_ban' => 0,
            ]);
            $this->userInfo->save();
        }
    }

    // Test create functionality
    // Test create functionality
    public function testCreateAdvertisement()
    {
        // Ensure user info is available
        $userInfo = $this->userInfo;

        // Create a new Advertisement
        $advertisement = new Advertisement();
        $advertisement->title = 'New Advertisement';
        $advertisement->description = 'Advertisement description';
        $advertisement->user_info_id = $userInfo->id;  // Add user_info_id to resolve the issue

        // Save the advertisement
        $saveResult = $advertisement->save();
        if (!$saveResult) {
            // Print validation errors if the save fails
            $this->fail("Failed to save Advertisement: " . implode(', ', array_map(function ($error) {
                return implode(', ', $error); // Handle array of errors inside fields
            }, $advertisement->errors)));
        }

        // Retrieve the advertisement from the database to ensure it was saved
        $savedAdvertisement = Advertisement::findOne(['title' => 'New Advertisement']);
        $this->assertInstanceOf(Advertisement::class, $savedAdvertisement);
        $this->assertEquals('New Advertisement', $savedAdvertisement->title);
    }




    // Test read functionality
    public function testFindAdvertisement()
    {
        // Given an Advertisement with ID = 1 is in the database
        $advertisement = Advertisement::findOne(1);

        // Ensure the advertisement is found
        $this->assertInstanceOf(Advertisement::class, $advertisement);

        // Check the title or other attributes to validate the specific advertisement
        $this->assertEquals('ad1', $advertisement->title);  // Modify with correct title value
    }

    // Test update functionality
    public function testUpdateAdvertisement()
    {
        // Assuming there is an advertisement with ID = 1
        $advertisement = Advertisement::findOne(1);

        // Update its properties
        $advertisement->title = 'Updated Title';
        $advertisement->description = 'Updated description';

        // Save the changes
        $this->assertTrue($advertisement->save());

        // Retrieve the updated advertisement
        $updatedAdvertisement = Advertisement::findOne(1);
        $this->assertInstanceOf(Advertisement::class, $updatedAdvertisement);
        $this->assertEquals('Updated Title', $updatedAdvertisement->title);
    }

    // Test delete functionality
    public function testDeleteAdvertisement()
    {
        // Check if an advertisement with ID = 1 exists
        $advertisement = Advertisement::findOne(1);
        if (!$advertisement) {
            // Create a new advertisement if none exists
            $advertisement = new Advertisement();
            $advertisement->title = 'Temp Advertisement';
            $advertisement->description = 'Temp description';
            $advertisement->save();
        }

        // Delete the advertisement
        $this->assertTrue($advertisement->delete() > 0);  // Correct deletion assertion

        // Verify the advertisement is deleted
        $deletedAdvertisement = Advertisement::findOne(1);
        $this->assertNull($deletedAdvertisement);
    }
}
