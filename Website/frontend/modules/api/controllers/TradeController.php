<?php

namespace frontend\modules\api\controllers;

use common\models\Item;
use common\models\Trade;
use common\models\TradeProposal;
use common\models\TradeProposalItem;
use Throwable;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\StaleObjectException;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;


class TradeController extends ActiveController
{
    public $modelClass = Trade::class;

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
     * @throws BadRequestHttpException
     */
    public function actionCreate(): array
    {
        $request = Yii::$app->request;
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $advertisementId = $request->post('advertisement_id');
            $message = $request->post('message');
            $itemIds = $request->post('item_ids');

            if (empty($advertisementId)) {
                throw new InvalidArgumentException('Advertisement ID required');
            }

            if (empty($message)) {
                throw new InvalidArgumentException('Message required');
            }

            if (empty($itemIds)) {
                throw new InvalidArgumentException('Item IDs required');
            }

            $validItemIds = Item::find()->select('id')->where(['id' => $itemIds])->column();
            $invalidItemIds = array_diff($itemIds, $validItemIds);

            if (!empty($invalidItemIds)) {
                throw new InvalidArgumentException('The following Item IDs are invalid: ' . implode(', ', $invalidItemIds));
            }

            $trade = new Trade();
            $trade->advertisement_id = $advertisementId;
            $trade->user_info_id = Yii::$app->user->id;
            $trade->state = 0;

            if (!$trade->save()) {
                throw new StaleObjectException('Failed to save Trade: ' . json_encode($trade->errors));
            }

            $tradeProposal = new TradeProposal();
            $tradeProposal->trade_id = $trade->id;
            $tradeProposal->message = $message;
            $tradeProposal->state = 0;

            if (!$tradeProposal->save()) {
                throw new StaleObjectException('Failed to save TradeProposal: ' . json_encode($tradeProposal->errors));
            }

            foreach ($itemIds as $itemId) {
                $tradeProposalItem = new TradeProposalItem();
                $tradeProposalItem->trade_proposal_id = $tradeProposal->id;
                $tradeProposalItem->item_id = $itemId;

                if (!$tradeProposalItem->save()) {
                    throw new StaleObjectException('Failed to save TradeProposalItem: ' . json_encode($tradeProposalItem->errors));
                }
            }

            $transaction->commit();

            foreach ($trade->tradeProposals as $item) {
                $item->tradeProposalItems;
            }

            return Trade::find()
                ->with(['tradeProposals.tradeProposalItems'])
                ->where(['trade.id' => $trade->id])
                ->asArray()
                ->one();

        } catch (InvalidArgumentException|StaleObjectException $e) {
            $transaction->rollBack();
            throw new BadRequestHttpException($e->getMessage());
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw new BadRequestHttpException('An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
