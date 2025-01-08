<?php

namespace frontend\tests\unit;

use common\models\SavedAdvertisement;
use common\models\UserInfo;
use common\models\Advertisement;
use yii\db\Exception;

class SavedAdvertisementTest extends \Codeception\Test\Unit
{
    protected $tester;
    protected $userInfo;
    protected $advertisement;

    // Setup UserInfo and Advertisement data before running tests
    protected function _before()
    {
        // Ensure a user exists
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

        // Ensure an advertisement exists
        $this->advertisement = Advertisement::find()->one();
        if (!$this->advertisement) {
            $this->advertisement = new Advertisement([
                'title' => 'Test Advertisement',
                'description' => 'This is a test advertisement.',
            ]);
            $this->advertisement->save();
        }
    }

    // Test create functionality for SavedAdvertisement
    public function testCreateSavedAdvertisement()
    {
        $model = new SavedAdvertisement();
        $model->user_info_id = $this->userInfo->id;
        $model->advertisement_id = $this->advertisement->id;
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');

        // Check if saved advertisement already exists
        $existingSavedAd = SavedAdvertisement::findOne([
            'user_info_id' => $model->user_info_id,
            'advertisement_id' => $model->advertisement_id,
        ]);

        if ($existingSavedAd) {
            $this->fail('Saved Advertisement already exists.');
        }

        $this->assertTrue($model->save());

        // Retrieve the saved advertisement
        $savedAd = SavedAdvertisement::findOne([
            'user_info_id' => $model->user_info_id,
            'advertisement_id' => $model->advertisement_id,
        ]);
        $this->assertInstanceOf(SavedAdvertisement::class, $savedAd);
        $this->assertEquals($this->userInfo->id, $savedAd->user_info_id);
        $this->assertEquals($this->advertisement->id, $savedAd->advertisement_id);
    }

    // Test delete functionality for SavedAdvertisement
    public function testDeleteSavedAdvertisement()
    {
        // Create a saved advertisement
        $savedAd = new SavedAdvertisement([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $savedAd->save();

        $this->assertTrue($savedAd->delete() > 0);

        // Ensure it's deleted
        $deletedAd = SavedAdvertisement::findOne([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ]);
        $this->assertNull($deletedAd);
    }

    // Test create attempt when advertisement is already saved
    public function testCreateSavedAdvertisementAlreadyExists()
    {
        // Pre-create a saved advertisement
        $savedAd = new SavedAdvertisement([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ]);
        $savedAd->save();

        // Try creating the same saved advertisement again
        $newSavedAd = new SavedAdvertisement([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ]);

        // Ensure it won't save again
        $this->assertFalse($newSavedAd->save());

        // Verify an appropriate error message is set
        $this->assertNotEmpty($newSavedAd->errors); // Check for any errors
    }

    // Test find functionality for SavedAdvertisement by user_info_id
    public function testFindSavedAdvertisementsByUserInfoId()
    {
        // Create a saved advertisement for the test user
        $savedAd = new SavedAdvertisement([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ]);
        $savedAd->save();

        // Fetch saved advertisements for the user
        $savedAds = SavedAdvertisement::find()->where(['user_info_id' => $this->userInfo->id])->all();
        $this->assertNotEmpty($savedAds);

        // Verify the correct advertisement is saved
        $this->assertEquals($this->advertisement->id, $savedAds[0]->advertisement_id);
    }
}
