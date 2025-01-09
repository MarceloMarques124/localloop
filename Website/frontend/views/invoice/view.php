<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $invoice common\models\Invoice */
/* @var $tradeProposal common\models\TradeProposal */
/* @var $tradeProposalItems common\models\TradeProposalItem[] */
/* @var $userInfo common\models\User */

$this->title = 'Invoice ' . $invoice->id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="invoice-view" style="font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">

    <h1 style="text-align: center; color: #333;"><?= Html::encode($this->title) ?></h1>

    <!-- User Information Section -->
    <div style="border-bottom: 2px solid #ddd; padding-bottom: 15px; margin-bottom: 20px;">
        <h3 style="margin-top: 0; color: #333;">User Information</h3>
        <p><strong style="color: #555;">User Name:</strong> <?= Html::encode($userInfo->name) ?></p>
        <p><strong style="color: #555;">Email:</strong> <?= Html::encode($userInfo->user->email) ?></p>
        <p><strong style="color: #555;">Address:</strong> <?= Html::encode($userInfo->address) ?></p>
        <p><strong style="color: #555;">Postal-code:</strong> <?= Html::encode($userInfo->postal_code) ?></p>
    </div>

    <!-- Invoice Details Section -->
    <div style="margin-bottom: 30px;">
        <h3 style="color: #333;">Invoice Details</h3>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Advertisement title:</strong></td>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= Html::encode($invoice->trade->advertisement->title) ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Created At:</strong></td>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= Html::encode($invoice->created_at) ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Updated At:</strong></td>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= Html::encode($invoice->updated_at) ?></td>
            </tr>
        </table>
    </div>

    <!-- Display Trade Proposal Information if the Trade is Closed -->
    <?php if ($invoice->trade->state == 0): ?>
        <div style="border-top: 2px solid #ddd; padding-top: 20px;">
            <h3 style="color: #333;">Trade Proposal Information</h3>
            <p><strong style="color: #555;">Proposal State:</strong> <?= $tradeProposal->state == 1 ? 'Accepted' : ($tradeProposal->state == 2 ? 'Rejected' : 'Pending') ?></p>
            <p><strong style="color: #555;">Message:</strong> <?= Html::encode($tradeProposal->message) ?></p>

            <!-- Display Trade Proposal Items -->
            <h4 style="color: #333;">Trade Proposal Items</h4>
            <ul style="list-style: none; padding-left: 0;">
                <?php foreach ($tradeProposalItems as $item): ?>
                    <li style="border-bottom: 1px solid #ddd; padding: 8px;">
                        <strong>Item ID:</strong> <?= Html::encode($item->item->name) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <p style="margin-top: 20px;">The trade is not closed yet, so no proposal details are shown.</p>
    <?php endif; ?>
</div>