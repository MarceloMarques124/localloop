<?php

namespace frontend\modules\api\controllers;

use common\models\Report;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\base\DynamicModel;
use yii;
use yii\web\Response;
use yii\db\StaleObjectException;



class ReportController extends ActiveController
{
    public $modelClass = Report::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }


    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Check if user is logged in
        if (Yii::$app->user->isGuest) {
            return ['status' => 'error', 'message' => 'User not logged in.'];
        }

        $request = Yii::$app->request;
        $entityType = $request->get('entityType'); // Should match 'advertisement', 'trade', or 'user'
        $reportId = $request->get('reportId'); // ID being reported

        if (!$entityType || !$reportId) {
            return ['status' => 'error', 'message' => 'Invalid parameters.'];
        }

        $report = new Report();
        $report->author_id = Yii::$app->user->id; // Assign the logged-in user ID

        if ($entityType === 'advertisement') {
            $report->advertisement_id = $reportId;
        } elseif ($entityType === 'trade') {
            $report->trade_id = $reportId;
        } elseif ($entityType === 'user') {
            $report->user_info_id = $reportId;
        } else {
            return ['status' => 'error', 'message' => 'Invalid entity type.'];
        }

        // Save the report
        if (!$report->save()) {
            throw new StaleObjectException('Failed to save Report: ' . json_encode($report->errors));
        }

        return ['status' => 'success', 'message' => 'Report created successfully.'];
    }
}
