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
            $this->userInfo->save();
        }

        $this->advertisement = Advertisement::find()->one();
        if (!$this->advertisement) {
            $this->advertisement = new Advertisement([
                'title' => 'Test Advertisement',
                'description' => 'This is a test advertisement.',
            ]);
            $this->advertisement->save();
        }
    }

    public function testCreateSavedAdvertisement()
    {
        $model = new SavedAdvertisement();
        $model->user_info_id = $this->userInfo->id;
        $model->advertisement_id = $this->advertisement->id;
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');

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

    public function testDeleteSavedAdvertisement()
    {
        $savedAd = new SavedAdvertisement([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $savedAd->save();

        $this->assertTrue($savedAd->delete() > 0);

        $deletedAd = SavedAdvertisement::findOne([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ]);
        $this->assertNull($deletedAd);
    }

    public function testCreateSavedAdvertisementAlreadyExists()
    {
        $savedAd = new SavedAdvertisement([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ]);
        $savedAd->save();

        $newSavedAd = new SavedAdvertisement([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ]);

        $this->assertFalse($newSavedAd->save());

        $this->assertNotEmpty($newSavedAd->errors);
    }

    public function testFindSavedAdvertisementsByUserInfoId()
    {
        $savedAd = new SavedAdvertisement([
            'user_info_id' => $this->userInfo->id,
            'advertisement_id' => $this->advertisement->id,
        ]);
        $savedAd->save();

        $savedAds = SavedAdvertisement::find()->where(['user_info_id' => $this->userInfo->id])->all();
        $this->assertNotEmpty($savedAds);

        $this->assertEquals($this->advertisement->id, $savedAds[0]->advertisement_id);
    }
}
