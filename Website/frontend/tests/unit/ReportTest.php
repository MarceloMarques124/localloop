<?php

namespace frontend\tests\unit;

use common\models\Report;
use common\models\UserInfo;
use common\models\Advertisement;
use common\models\Trade;
use yii\db\Exception;

class ReportTest extends \Codeception\Test\Unit
{
    protected $tester;
    protected $userInfo;
    protected $advertisement;
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

        $this->advertisement = Advertisement::find()->one();
        if (!$this->advertisement) {
            $this->advertisement = new Advertisement([
                'title' => 'Test Advertisement',
                'description' => 'Test Description',
            ]);
            $this->advertisement->save();
        }

        $this->trade = Trade::find()->one();
        if (!$this->trade) {
            $this->trade = new Trade([
                'advertisement_id' => $this->advertisement->id,
                'user_info_id' => $this->userInfo->id,
                'state' => 1,
            ]);
            $this->trade->save();
        }
    }

    public function testCreateReport()
    {
        $userInfo = $this->userInfo;
        $advertisement = $this->advertisement;
        $trade = $this->trade;

        $report = new Report();
        $report->author_id = $userInfo->id;
        $report->advertisement_id = $advertisement->id;
        $report->created_at = date('Y-m-d H:i:s');
        $report->updated_at = date('Y-m-d H:i:s');
        $this->assertTrue($report->save(), 'Failed to save report for advertisement.');

        $report = new Report();
        $report->author_id = $userInfo->id;
        $report->trade_id = $trade->id;
        $report->created_at = date('Y-m-d H:i:s');
        $report->updated_at = date('Y-m-d H:i:s');
        $this->assertTrue($report->save(), 'Failed to save report for trade.');
    }

    public function testUpdateReport()
    {
        $report = Report::find()->one();
        $this->assertNotNull($report, 'Report not found.');

        $newAdvertisement = Advertisement::find()->one();
        if ($newAdvertisement) {
            $report->advertisement_id = $newAdvertisement->id;
            $this->assertTrue($report->save(), 'Failed to update report.');
        } else {
            $this->fail('No other advertisement found to update the report.');
        }
    }

    public function testFindAndViewReport()
    {
        $report = Report::find()->one();
        $this->assertNotNull($report, 'Report not found.');

        $this->assertInstanceOf(UserInfo::class, $report->author, 'Report author not found.');
        if ($report->advertisement_id) {
            $this->assertInstanceOf(Advertisement::class, $report->advertisement, 'Advertisement not found.');
        }
        if ($report->trade_id) {
            $this->assertInstanceOf(Trade::class, $report->trade, 'Trade not found.');
        }
    }

    public function testDeleteReport()
    {
        $report = Report::find()->one();
        $this->assertNotNull($report, 'Report not found.');

        $this->assertTrue($report->delete() > 0, 'Failed to delete report.');

        +$deletedReport = Report::findOne($report->id);
        $this->assertNull($deletedReport, 'Failed to delete report.');
    }

    public function testFindReportWithRelations()
    {
        $report = Report::find()->one();
        $this->assertNotNull($report, 'Report not found.');

        $this->assertInstanceOf(UserInfo::class, $report->author, 'Failed to find the related Author.');
        if ($report->advertisement_id) {
            $this->assertInstanceOf(Advertisement::class, $report->advertisement, 'Failed to find the related Advertisement.');
        }
        if ($report->trade_id) {
            $this->assertInstanceOf(Trade::class, $report->trade, 'Failed to find the related Trade.');
        }
    }
}
