<?php

use yii\helpers\Html;
?>

<h1>Proposals</h1>

<h2>Sent Proposals</h2>
<table>
    <tr>
        <th>Trade</th>
        <th>State</th>
        <th>Message</th>
        <th>Items</th>
        <th>Date</th>
        <th>Action</th> <!-- Added an Action column -->
    </tr>
    <?php foreach ($sentProposals as $proposal): ?>
        <tr>
            <td><?= $proposal->trade->advertisement->title ?? 'N/A' ?></td>
            <td><?= $proposal->state == 0 ? 'Pending' : ($proposal->state == 1 ? 'Accepted' : 'Rejected') ?></td>
            <td><?= $proposal->message ?></td>
            <td>
                <ul>
                    <?php foreach ($proposal->tradeProposalItems as $item): ?>
                        <li><?= $item->item->name ?? 'Unknown Item' ?></li>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td><?= date('Y-m-d', strtotime($proposal->created_at)) ?></td>
            <td>
                <?php if ($proposal->state == 0): ?>
                    <?= Html::a('Accept', ['trade-proposal/update-state', 'id' => $proposal->id, 'state' => 1], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
                    <?= Html::a('Reject', ['trade-proposal/update-state', 'id' => $proposal->id, 'state' => 2], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
                <?php endif; ?>
            </td> <!-- Action buttons appear for pending proposals -->
        </tr>
    <?php endforeach; ?>
</table>

<h2>Received Proposals</h2>
<table>
    <tr>
        <th>Advertisement</th>
        <th>State</th>
        <th>Message</th>
        <th>Items</th>
        <th>Date</th>
        <th>Action</th> <!-- Added an Action column -->
    </tr>
    <?php foreach ($receivedProposals as $proposal): ?>
        <tr>
            <td><?= $proposal->trade->advertisement->title ?? 'N/A' ?></td>
            <td><?= $proposal->state == 0 ? 'Pending' : ($proposal->state == 1 ? 'Accepted' : 'Rejected') ?></td>
            <td><?= $proposal->message ?></td>
            <td>
                <ul>
                    <?php foreach ($proposal->tradeProposalItems as $item): ?>
                        <li><?= $item->item->name ?? 'Unknown Item' ?></li>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td><?= date('Y-m-d', strtotime($proposal->created_at)) ?></td>
            <td>
                <?php if ($proposal->state == 0): ?>
                    <?= Html::a('Accept', ['trade-proposal/update-state', 'id' => $proposal->id, 'state' => 1], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
                    <?= Html::a('Reject', ['trade-proposal/update-state', 'id' => $proposal->id, 'state' => 2], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
                <?php endif; ?>
            </td> <!-- Action buttons appear for pending proposals -->
        </tr>
    <?php endforeach; ?>
</table>