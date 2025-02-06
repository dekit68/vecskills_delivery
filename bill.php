<?php
    require_once 'db.php';
    require_once 'class/modules/data.php';
    $db = new Database();
    $pdo = $db->getConnect();
    $dataHandler = new Data($pdo, NULL);
    $id = $_GET['id'];

    $order = $dataHandler->get1("SELECT orders.*, CONCAT(users.fname,' ', users.lname) AS c_name, shop.name AS shop_name, users.address AS userAddress, users.phone AS phone  
                                  FROM orders 
                                  LEFT JOIN users ON orders.user_id = users.id 
                                  JOIN shop ON orders.shop_id = shop.id 
                                  WHERE orders.id = $id");

    $order_detail = $dataHandler->get("SELECT order_detail.*, 
                                              food.name AS food_name, 
                                              food.price AS food_price, 
                                              food.discount AS food_discount, 
                                              food_type.name AS food_type_name, 
                                              shop.name AS shop_name 
                                       FROM order_detail
                                       JOIN food ON food.id = order_detail.food_id 
                                       JOIN food_type ON food_type.id = food.type_id
                                       JOIN shop ON shop.id = food.shop_id 
                                       WHERE order_detail.id = $id");


    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf([ 
        'default_font' => 'garuda' 
    ]);

    ob_start();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน</title>
    <style>
        body {
            font-family: 'Garuda';
            font-size: 14px;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .total {
            text-align: right;
            padding-right: 20px;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
            padding-right: 50px;
        }

        .delivery-info {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>ใบเสร็จรับเงิน</h2>
        </div>

        <p><strong>วันที่:</strong> <?= date('d/m/Y') ?></p>
        <p><strong>ลูกค้า:</strong> <?= $order['c_name'] ?></p>
        <p><strong>ที่อยู่จัดส่ง:</strong> <?= $order['userAddress'] ?></p>
        <p><strong>หมายเลขการจัดส่ง:</strong> <?= $order['id'] ?></p>
        <p><strong>วันที่จัดส่ง:</strong> <?= date('d/m/Y', strtotime($order['time'])) ?></p>

        <table>
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รายการ</th>
                    <th>จำนวน</th>
                    <th>ราคาต่อหน่วย (บาท)</th>
                    <th>ราคารวม (บาท)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $total = 0;
                    foreach ($order_detail as $index => $item) {
                        $item_total = $item['qty'] * $item['food_price'];
                        $total += $item_total;
                ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $item['food_name'] ?></td>
                    <td><?= $item['qty'] ?> ชิ้น</td>
                    <td><?= number_format($item['food_price'], 2) ?></td>
                    <td><?= number_format($item_total, 2) ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" class="total"><strong>รวมทั้งหมด</strong></td>
                    <td><strong><?= number_format($total, 2) ?> บาท</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="delivery-info">
            <p><strong>ยอดรวมทั้งหมด:</strong> <?= number_format($total, 2) ?> บาท</p>
        </div>

        <div class="signature">
            <p>(ผู้รับเงิน)</p>
            <p>............................................</p>
            <p><strong>วันที่:</strong> <?= date('d/m/Y') ?></p>  <!-- แสดงวันที่ -->
        </div>

    </div>
</body>

</html>

<?php
    $html = ob_get_contents();
    ob_end_clean();
    $mpdf->WriteHTML($html);
    $mpdf->Output('ใบเสร็จรับเงิน_delivery.pdf', 'I');
?>
