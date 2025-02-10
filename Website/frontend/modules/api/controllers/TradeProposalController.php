<?php

namespace frontend\modules\api\controllers;

use common\models\Trade;
use common\models\TradeProposal;
use Yii;
use yii\db\Exception;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;


class TradeProposalController extends ActiveController
{
    public $modelClass = TradeProposal::class;

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    /**
     * @throws Exception
     * @throws BadRequestHttpException
     */
    public function actionUpdateStatus($id): array
    {
        $newState = Yii::$app->request->post();

        if (!isset($newState)) {
            throw new BadRequestHttpException('State is required.');
        }

        $tradeProposal = TradeProposal::findOne($id);

        if (!$tradeProposal) {
            throw new BadRequestHttpException('TradeProposal not found.');
        }

        if (!in_array($newState, [TradeProposal::STATE_PENDING, TradeProposal::STATE_ACCEPTED, TradeProposal::STATE_REJECTED])) {
            throw new BadRequestHttpException('Invalid state value.');
        }

        $tradeProposal->state = $newState;

        if (!$tradeProposal->save()) {
            throw new BadRequestHttpException('Failed to update state: ' . json_encode($tradeProposal->errors));
        }

        return $tradeProposal->toArray();
    }


    /**
     * @throws Exception
     * @throws BadRequestHttpException
     */
    public function actionAccept($id): array
    {
        $tradeProposal = TradeProposal::findOne($id);

        if (!$tradeProposal) {
            throw new BadRequestHttpException('TradeProposal not found.');
        }

        $tradeProposal->state = TradeProposal::STATE_ACCEPTED;

        $trade = $tradeProposal->trade;
        $trade->state = Trade::STATE_ACCEPTED;

        if (!$trade->save()) {
            throw new BadRequestHttpException('Failed to update trade state: ' . json_encode($trade->errors));
        }

        if (!$tradeProposal->save()) {
            throw new BadRequestHttpException('Failed to update the accepted proposal state: ' . json_encode($tradeProposal->errors));
        }

        return $tradeProposal->toArray();
    }
}
