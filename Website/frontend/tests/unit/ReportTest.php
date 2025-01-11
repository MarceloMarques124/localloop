<?php

namespace frontend\tests\unit;

use common\models\Report;
use common\models\UserInfo;
use yii\db\Exception;

class ReportTest extends \Codeception\Test\Unit
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
            $this->userInfo->save();
        }
    }

    public function testCreateReportWithoutAdvertisement()
    {
        $report = new Report([
            'author_id' => $this->userInfo->id,
            'advertisement_id' => null,
            'trade_id' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->assertTrue($report->save(), 'Failed to save report without advertisement.');

        $savedReport = Report::findOne($report->id);
        $this->assertNull($savedReport->advertisement_id, 'Advertisement ID should be null for this test.');
        $this->assertNull($savedReport->trade_id, 'Trade ID should be null for this test.');

        $this->assertInstanceOf(UserInfo::class, $savedReport->author, 'Failed to find the related Author.');
    }

    public function testCreateReportWithEmptyAdvertisementId()
    {
        $report = new Report([
            'author_id' => $this->userInfo->id,
            'advertisement_id' => null,
            'trade_id' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->assertTrue($report->save(), 'Failed to save report without advertisement.');

        $savedReport = Report::findOne($report->id);
        $this->assertNotNull($savedReport, 'Report should be saved.');
        $this->assertNull($savedReport->advertisement, 'Advertisement should be null when it is not related.');
    }

    public function testFindAndViewReportWithNoRelations()
    {
        $report = new Report([
            'author_id' => $this->userInfo->id,
            'advertisement_id' => null,
            'trade_id' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->assertTrue($report->save(), 'Failed to save report with no related advertisement or trade.');

        $retrievedReport = Report::findOne($report->id);
        $this->assertNotNull($retrievedReport, 'Report should be retrievable even if no relations exist.');
        $this->assertNull($retrievedReport->advertisement_id, 'Advertisement ID should be null.');
        $this->assertNull($retrievedReport->trade_id, 'Trade ID should be null.');
    }

    public function testReportHasValidAuthor()
    {
        $report = new Report([
            'author_id' => $this->userInfo->id,
            'advertisement_id' => null,
            'trade_id' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->assertTrue($report->save(), 'Failed to save report with a user but no advertisement.');

        $retrievedReport = Report::findOne($report->id);
        $this->assertNotNull($retrievedReport->author, 'Failed to find the report’s author.');
        $this->assertInstanceOf(UserInfo::class, $retrievedReport->author, 'Failed to link the correct UserInfo.');
    }
}
