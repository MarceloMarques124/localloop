<?php


namespace frontend\tests\unit;

use common\models\Trade;
use common\models\Advertisement;
use common\models\UserInfo;
use yii\db\Exception;

class TradeTest extends \Codeception\Test\Unit
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
                'description' => 'Test Advertisement Description',
                'user_info_id' => $this->userInfo->id,
            ]);
            $this->advertisement->save();
        }
    }

    public function testCreateTrade()
    {
        $userInfo = $this->userInfo;
        $advertisement = $this->advertisement;

        $trade = new Trade();
        $trade->advertisement_id = $advertisement->id;
        $trade->user_info_id = $userInfo->id;
        $trade->state = 1;

        $saveResult = $trade->save();
        if (!$saveResult) {
            $this->fail("Failed to save Trade: " . implode(', ', array_map(function ($error) {
                return implode(', ', $error);
            }, $trade->errors)));
        }

        $savedTrade = Trade::findOne(['advertisement_id' => $advertisement->id, 'user_info_id' => $userInfo->id]);
        $this->assertInstanceOf(Trade::class, $savedTrade);
        $this->assertEquals($advertisement->id, $savedTrade->advertisement_id);
        $this->assertEquals($userInfo->id, $savedTrade->user_info_id);
    }



    public function testUpdateTrade()
    {
        $trade = Trade::find()->where(['advertisement_id' => $this->advertisement->id, 'user_info_id' => $this->userInfo->id])->one();
        if (!$trade) {
            $trade = new Trade([
                'advertisement_id' => $this->advertisement->id,
                'user_info_id' => $this->userInfo->id,
                'state' => 1,
            ]);
            $trade->save();
        }

        $trade->state = 2;

        $this->assertTrue($trade->save());

        $updatedTrade = Trade::find()->where(['advertisement_id' => $this->advertisement->id, 'user_info_id' => $this->userInfo->id])->one();
        $this->assertInstanceOf(Trade::class, $updatedTrade);
        $this->assertEquals(2, $updatedTrade->state);
    }

    public function testDeleteTrade()
    {
        $trade = Trade::find()->where(['advertisement_id' => $this->advertisement->id, 'user_info_id' => $this->userInfo->id])->one();
        if (!$trade) {
            $trade = new Trade([
                'advertisement_id' => $this->advertisement->id,
                'user_info_id' => $this->userInfo->id,
                'state' => 1,
            ]);
            $trade->save();
        }

        $this->assertTrue($trade->delete() > 0);

        $deletedTrade = Trade::findOne($trade->id);
        $this->assertNull($deletedTrade);
    }

    public function testFindTrade()
    {
        $trade = Trade::find()->where(['advertisement_id' => $this->advertisement->id, 'user_info_id' => $this->userInfo->id])->one();
        if (!$trade) {
            $trade = new Trade([
                'advertisement_id' => $this->advertisement->id,
                'user_info_id' => $this->userInfo->id,
                'state' => 1,
            ]);
            $trade->save();
        }

        $foundTrade = Trade::find()->where(['advertisement_id' => $this->advertisement->id, 'user_info_id' => $this->userInfo->id])->one();
        $this->assertInstanceOf(Trade::class, $foundTrade);
        $this->assertEquals($this->advertisement->id, $foundTrade->advertisement_id);
        $this->assertEquals($this->userInfo->id, $foundTrade->user_info_id);
    }
}
