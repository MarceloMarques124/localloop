<?php

namespace frontend\tests\unit;

use common\models\SavedAdvertisement;
use common\models\Advertisement;
use common\models\UserInfo;

class SavedAdvertisementTest extends \Codeception\Test\Unit
{
    protected $tester;
    protected $userInfo;
    protected $advertisement;

    // Before each test, ensure we have valid data
    protected function _before()
    {
        // Create UserInfo if none exists
        $this->userInfo = UserInfo::find()->one();
        if (!$this->userInfo) {
            $this->userInfo = new UserInfo([
                'name' => 'Test User',
                'address' => 'Test Address',
                'postal_code' => '12345678',
                'flagged_for_ban' => 0,
            ]);
            $this->userInfo->save();
        }

        // Create Advertisement if none exists
        $this->advertisement = Advertisement::find()->one();
        if (!$this->advertisement) {
            $this->advertisement = new Advertisement([
                'title' => 'Test Advertisement',
                'description' => 'Test Advertisement Description',
                'user_info_id' => $this->userInfo->id,
            ]);
            $this->advertisement->save();
        }
    }

    // Test creating a SavedAdvertisement
    public function testCreateSavedAdvertisement()
    {
        $userInfo = $this->userInfo;
        $advertisement = $this->advertisement;

        $savedAdvertisement = new SavedAdvertisement();
        $savedAdvertisement->user_info_id = $userInfo->id;
        $savedAdvertisement->advertisement_id = $advertisement->id;
        $savedAdvertisement->created_at = date('Y-m-d H:i:s');
        $savedAdvertisement->updated_at = date('Y-m-d H:i:s');

        // Check if saving was successful
        if (!$savedAdvertisement->save()) {
            $this->fail("Failed to save SavedAdvertisement: " . implode(', ', array_map(function ($error) {
                return implode(', ', $error);
            }, $savedAdvertisement->errors)));
        }

        // Find the saved SavedAdvertisement
        $savedAdFromDb = SavedAdvertisement::findOne([
            'user_info_id' => $userInfo->id,
            'advertisement_id' => $advertisement->id,
        ]);

        // Verify that it has been saved
        $this->assertInstanceOf(SavedAdvertisement::class, $savedAdFromDb);
        $this->assertEquals($userInfo->id, $savedAdFromDb->user_info_id);
        $this->assertEquals($advertisement->id, $savedAdFromDb->advertisement_id);
    }

    public function testUpdateSavedAdvertisement()
    {
        $savedAdvertisement = SavedAdvertisement::find()->where([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ])->one();

        // Create the SavedAdvertisement if none exists
        if (!$savedAdvertisement) {
            $savedAdvertisement = new SavedAdvertisement([
                'user_info_id' => $this->userInfo->id,
                'advertisement_id' => $this->advertisement->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $savedAdvertisement->save();
        }

        // Update the 'updated_at' attribute
        $savedAdvertisement->updated_at = date('Y-m-d H:i:s');
        $this->assertTrue($savedAdvertisement->save(), 'Failed to save the updated advertisement');

        // Fetch the updated SavedAdvertisement
        $updatedSavedAd = SavedAdvertisement::find()->where([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ])->one();

        $this->assertInstanceOf(SavedAdvertisement::class, $updatedSavedAd);
        $this->assertEquals($savedAdvertisement->updated_at, $updatedSavedAd->updated_at);
    }

    public function testDeleteSavedAdvertisement()
    {
        $savedAdvertisement = SavedAdvertisement::find()->where([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ])->one();

        // Create the SavedAdvertisement if none exists
        if (!$savedAdvertisement) {
            $savedAdvertisement = new SavedAdvertisement([
                'user_info_id' => $this->userInfo->id,
                'advertisement_id' => $this->advertisement->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $savedAdvertisement->save();
        }

        // Delete the SavedAdvertisement and confirm deletion
        $deleteResult = $savedAdvertisement->delete();
        $this->assertTrue($deleteResult > 0, 'Failed to delete SavedAdvertisement.');

        // Verify it is deleted
        $deletedSavedAd = SavedAdvertisement::find()->where([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ])->one();

        $this->assertNull($deletedSavedAd);
    }
}
