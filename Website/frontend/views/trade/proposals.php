<h1>Proposals</h1>

<h2>Sent Proposals</h2>
<table>
    <tr>
        <th>Trade</th>
        <th>State</th>
        <th>Message</th>
        <th>Items</th>
        <th>Date</th>
    </tr>
    <?php foreach ($sentProposals as $proposal): ?>
        <tr>
            <td><?= $proposal->trade->advertisement->title ?? 'N/A' ?></td>
            <td><?= $proposal->state ?></td>
            <td><?= $proposal->message ?></td>
            <td>
                <ul>
                    <?php foreach ($proposal->tradeProposalItems as $item): ?>
                        <li><?= $item->item->name ?? 'Unknown Item' ?></li>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td><?= date('Y-m-d', strtotime($proposal->created_at)) ?></td>
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
    </tr>
    <?php foreach ($receivedProposals as $proposal): ?>
        <tr>
            <td><?= $proposal->trade->advertisement->title ?? 'N/A' ?></td>
            <td><?= $proposal->state ?></td>
            <td><?= $proposal->message ?></td>
            <td>
                <ul>
                    <?php foreach ($proposal->tradeProposalItems as $item): ?>
                        <li><?= $item->item->name ?? 'Unknown Item' ?></li>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td><?= date('Y-m-d', strtotime($proposal->created_at)) ?></td>
        </tr>
    <?php endforeach; ?>
</table>