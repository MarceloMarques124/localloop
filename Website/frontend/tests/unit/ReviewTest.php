<?php

namespace frontend\tests\unit;

use common\models\Review;
use common\models\UserInfo;
use common\models\Trade;
use yii\db\Exception;

class ReviewTest extends \Codeception\Test\Unit
{
    protected $tester;
    protected $userInfo;
    protected $trade;

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

        // Ensure a trade exists, and create one if not
        $this->trade = Trade::find()->one();
        if (!$this->trade) {
            $this->trade = new Trade([
                'advertisement_id' => 1,  // Adjust to a valid advertisement id
                'user_info_id' => $this->userInfo->id,
                'state' => 1,
            ]);
            $this->trade->save();
        }
    }

    public function testCreateReview()
    {
        $userInfo = $this->userInfo;
        $trade = $this->trade;

        $review = new Review();
        $review->title = 'Great Trade';
        $review->message = 'It was a smooth trade, highly recommend!';
        $review->stars = 5;
        $review->user_info_id = $userInfo->id;
        $review->trade_id = $trade->id;

        $saveResult = $review->save();
        if (!$saveResult) {
            $this->fail("Failed to save Review: " . implode(', ', array_map(function ($error) {
                return implode(', ', $error); // Handle array of errors inside fields
            }, $review->errors)));
        }

        $savedReview = Review::findOne(['title' => 'Great Trade']);
        $this->assertInstanceOf(Review::class, $savedReview);
        $this->assertEquals('Great Trade', $savedReview->title);
        $this->assertEquals(5, $savedReview->stars);
    }


    public function testUpdateReview()
    {
        $review = Review::find()->where(['trade_id' => $this->trade->id, 'user_info_id' => $this->userInfo->id])->one();
        if (!$review) {
            $review = new Review([
                'title' => 'Good Trade',
                'message' => 'Satisfactory trade experience.',
                'stars' => 4,
                'user_info_id' => $this->userInfo->id,
                'trade_id' => $this->trade->id,
            ]);
            $review->save();
        }

        $review->stars = 3;

        $this->assertTrue($review->save());

        $updatedReview = Review::findOne($review->id);
        $this->assertInstanceOf(Review::class, $updatedReview);
        $this->assertEquals(3, $updatedReview->stars);
    }

    public function testDeleteReview()
    {
        $review = Review::find()->where(['trade_id' => $this->trade->id, 'user_info_id' => $this->userInfo->id])->one();
        if (!$review) {
            // If no review exists, create one
            $review = new Review([
                'title' => 'Temporary Review',
                'message' => 'Temporary review message.',
                'stars' => 4,
                'user_info_id' => $this->userInfo->id,
                'trade_id' => $this->trade->id,
            ]);
            $review->save();
        }

        $this->assertTrue($review->delete() > 0);

        $deletedReview = Review::findOne($review->id);
        $this->assertNull($deletedReview);
    }

    public function testFindReviewsByTrade()
    {
        $trade = Trade::find()->one();
        $review = new Review([
            'trade_id' => $trade->id,
            'user_info_id' => $this->userInfo->id,
            'title' => 'Great Trade',
            'message' => 'Everything went perfectly!',
            'stars' => 5,
        ]);
        $review->save();

        $reviews = Review::find()->where(['trade_id' => $trade->id])->all();
        $this->assertNotEmpty($reviews);
    }
}
