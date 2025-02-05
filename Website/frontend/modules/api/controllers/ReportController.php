<?php

namespace frontend\modules\api\controllers;

use common\models\Report;
use yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\Response;


class ReportController extends ActiveController
{
    public $modelClass = Report::class;

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }


    /**
     * @throws Exception
     * @throws StaleObjectException
     */
    public function actionCreate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $entityType = $request->get('entityType');
        $reportId = $request->get('reportId');

        if (!$entityType || !$reportId) {
            return ['status' => 'error', 'message' => 'Invalid parameters.'];
        }

        $report = new Report();
        $report->author_id = Yii::$app->user->id;

        if ($entityType === 'advertisement') {
            $report->advertisement_id = $reportId;
        } elseif ($entityType === 'trade') {
            $report->trade_id = $reportId;
        } elseif ($entityType === 'user') {
            $report->user_info_id = $reportId;
        } else {
            return ['status' => 'error', 'message' => 'Invalid entity type.'];
        }

        if (!$report->save()) {
            throw new StaleObjectException('Failed to save Report: ' . json_encode($report->errors));
        }

        return ['status' => 'success', 'message' => 'Report created successfully.'];
    }
}
