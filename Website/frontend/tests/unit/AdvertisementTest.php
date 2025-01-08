<?php

namespace frontend\tests\unit;

use common\models\Advertisement;
use common\models\UserInfo;
use Codeception\Test\Unit;

class AdvertisementTest extends Unit
{
    protected $tester;
    protected $userInfo;

    // Setup UserInfo and seed the database
    protected function _before()
    {
        $this->userInfo = UserInfo::find()->one();
        if (!$this->userInfo) {
            $this->userInfo = new UserInfo([
                'name' => 'Test User',
                'address' => 'Test Address',
                'postal_code' => '12345678',
                'flagged_for_ban' => 0,
            ]);
            $this->userInfo->save(false);
        }

        // Ensure there is at least one advertisement for testing
        if (!Advertisement::findOne(1)) {
            $this->createAdvertisement(1);
        }
    }

    private function createAdvertisement($id)
    {
        $ad = Advertisement::findOne($id);
        if (!$ad) {
            $ad = new Advertisement([
                'id' => $id,
                'user_info_id' => $this->userInfo->id,
                'title' => "ad{$id}",
                'description' => 'Test description',
                'is_service' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if (!$ad->save()) {
                echo "Failed to create Advertisement:\n";
                print_r($ad->errors);
            }
        }
    }

    // Test create functionality
    public function testCreateAdvertisement()
    {
        $advertisement = new Advertisement([
            'user_info_id' => $this->userInfo->id,
            'title' => 'New Advertisement',
            'description' => 'A description',
            'is_service' => 0,
        ]);

        $this->assertTrue($advertisement->save(), "Failed to create advertisement.");

        // Verify it exists in the database
        $savedAd = Advertisement::findOne(['title' => 'New Advertisement']);
        $this->assertNotNull($savedAd);
        $this->assertEquals('New Advertisement', $savedAd->title);
    }

    // Test read functionality
    public function testFindAdvertisement()
    {
        $advertisement = Advertisement::findOne(1);
        if (!$advertisement) {
            $this->fail("Advertisement with ID 1 does not exist.");
        }

        $this->assertInstanceOf(Advertisement::class, $advertisement);
        $this->assertEquals('ad1', $advertisement->title);
    }

    // Test update functionality
    public function testUpdateAdvertisement()
    {
        $advertisement = Advertisement::findOne(1);
        if (!$advertisement) {
            $this->fail("Advertisement with ID 1 does not exist.");
        }

        $advertisement->title = 'Updated Title';
        $advertisement->description = 'Updated description';
        $this->assertTrue($advertisement->save(), "Failed to update advertisement.");

        $updatedAd = Advertisement::findOne(1);
        $this->assertNotNull($updatedAd);
        $this->assertEquals('Updated Title', $updatedAd->title);
    }

    // Test delete functionality
    public function testDeleteAdvertisement()
    {
        $advertisement = Advertisement::findOne(1);
        if (!$advertisement) {
            // Create a temporary advertisement if it doesn't exist
            $this->createAdvertisement(1);
            $advertisement = Advertisement::findOne(1);
        }

        $this->assertNotNull($advertisement, "Failed to prepare advertisement for deletion.");
        $this->assertTrue($advertisement->delete() > 0, "Failed to delete advertisement.");

        $deletedAd = Advertisement::findOne(1);
        $this->assertNull($deletedAd, "Advertisement was not deleted successfully.");
    }
}
