<?php

namespace frontend\modules\api\controllers;

use common\models\Item;
use common\models\Trade;
use common\models\TradeProposal;
use common\models\TradeProposalItem;
use Throwable;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\Exception;
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
        unset($actions['create'], $actions['view']);
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

    public function actionView($id): array
    {
        try {
            $trade = Trade::find()
                ->with(['tradeProposals.tradeProposalItems'])
                ->where(['trade.id' => $id])
                ->one();

            if (!$trade) {
                throw new BadRequestHttpException('Trade not found');
            }

            $tradeData = $trade->toArray();
            $tradeData['trade_proposals'] = [];

            $creatorUserInfo = $trade->userInfo;
            $advertisement = $trade->advertisement;
            $advertiserUserInfo = $advertisement->userInfo;

            foreach ($trade->tradeProposals as $index => $tradeProposal) {
                $proposalData = $tradeProposal->toArray();

                if ($index % 2 == 0) {
                    $proposalData['user_id'] = $creatorUserInfo->id;
                    $proposalData['user_name'] = $creatorUserInfo->name;
                } else {
                    $proposalData['user_id'] = $advertiserUserInfo->id;
                    $proposalData['user_name'] = $advertiserUserInfo->name;
                }

                $proposalData['trade_proposal_items'] = $tradeProposal->tradeProposalItems;

                $tradeData['trade_proposals'][] = $proposalData;
            }

            return $tradeData;

        } catch (Throwable $e) {
            throw new BadRequestHttpException('An error occurred while fetching the trade: ' . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     * @throws BadRequestHttpException
     */
    public function actionUpdateStatus($id): array
    {
        $request = Yii::$app->request;
        $newState = $request->post('state');

        if (!isset($newState)) {
            throw new BadRequestHttpException('State is required.');
        }

        $tradeProposal = TradeProposal::findOne($id);

        if (!$tradeProposal) {
            throw new BadRequestHttpException('TradeProposal not found.');
        }

        if (!in_array($newState, [0, 1, 2])) {
            throw new BadRequestHttpException('Invalid state value.');
        }

        $tradeProposal->state = $newState;

        if (!$tradeProposal->save()) {
            throw new BadRequestHttpException('Failed to update state: ' . json_encode($tradeProposal->errors));
        }

        return $tradeProposal->toArray();
    }


    /**
     * @throws BadRequestHttpException
     */
    public function actionAddProposal($id): array
    {
        $request = Yii::$app->request;
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $message = $request->post('message');
            $itemIds = $request->post('item_ids');

            if (empty($message)) {
                throw new InvalidArgumentException('Message is required');
            }

            if (empty($itemIds)) {
                throw new InvalidArgumentException('Item IDs are required');
            }

            $validItemIds = Item::find()->select('id')->where(['id' => $itemIds])->column();
            $invalidItemIds = array_diff($itemIds, $validItemIds);

            if (!empty($invalidItemIds)) {
                throw new InvalidArgumentException('The following Item IDs are invalid: ' . implode(', ', $invalidItemIds));
            }

            $trade = Trade::findOne($id);

            if (!$trade) {
                throw new BadRequestHttpException('Trade not found');
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
