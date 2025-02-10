<?php

namespace frontend\tests\unit;

use common\models\Advertisement;
use common\models\UserInfo;
use Codeception\Test\Unit;

class AdvertisementTest extends Unit
{
    protected $tester;
    protected $userInfo;

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

        Advertisement::deleteAll(); // Ensure a clean database state
        $this->createAdvertisement(1, 'ad1');
    }

    private function createAdvertisement($id, $title)
    {
        $ad = new Advertisement([
            'id' => $id,
            'user_info_id' => $this->userInfo->id,
            'title' => $title,
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

    public function testCreateAdvertisement()
    {
        $advertisement = new Advertisement([
            'user_info_id' => $this->userInfo->id,
            'title' => 'New Advertisement',
            'description' => 'A description',
            'is_service' => 0,
        ]);

        $this->assertTrue($advertisement->save(), "Failed to create advertisement.");

        $savedAd = Advertisement::findOne(['title' => 'New Advertisement']);
        $this->assertNotNull($savedAd);
        $this->assertEquals('New Advertisement', $savedAd->title);
    }

    public function testFindAdvertisement()
    {
        $advertisement = Advertisement::findOne(1);
        if (!$advertisement) {
            $this->fail("Advertisement with ID 1 does not exist.");
        }

        echo "Found Advertisement Title: " . $advertisement->title . "\n";
        $this->assertEquals('ad1', $advertisement->title);
    }

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

    public function testDeleteAdvertisement()
    {
        $advertisement = Advertisement::findOne(1);
        if (!$advertisement) {
            $this->fail("Advertisement with ID 1 does not exist.");
        }

        $this->assertTrue($advertisement->delete() > 0, "Failed to delete advertisement.");

        $deletedAd = Advertisement::findOne(1);
        $this->assertNull($deletedAd, "Advertisement was not deleted successfully.");
    }
}
