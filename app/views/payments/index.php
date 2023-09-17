<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid mt-5">
        <div class="d-flex justify-content-between">
            <h2>Payment List</h2>
            <a href="<?= URLROOT ?>/Payment/create" class="btn btn-primary">Create</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Amount</th>
                        <th>Buyer</th>
                        <th>Receipt id</th>
                        <th>Items</th>
                        <th>Buyer Email</th>
                        <th>Buyer IP</th>
                        <th>Note</th>
                        <th>City</th>
                        <!-- <th>Hash Key</th> -->
                        <th>Entry At</th>
                        <th>Entry By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $item) : ?>
                    <tr>
                        <td><?= $item['id']; ?></td>
                        <td><?= $item['amount']; ?></td>
                        <td><?= $item['receipt_id']; ?></td>
                        <td><?= $item['items']; ?></td>
                        <td><?= $item['buyer_email']; ?></td>
                        <td><?= $item['buyer_ip']; ?></td>
                        <td><?= $item['note']; ?></td>
                        <td><?= $item['city']; ?></td>
                        <td><?= $item['phone']; ?></td>
                        <!-- <td><?= $item['hash_key']; ?></td> -->
                        <td><?= $item['entry_at']; ?></td>
                        <td><?= $item['entry_by']; ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>