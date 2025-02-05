<?php 

    require 'db.php';

    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT orders.*, shop.name AS shop_name FROM orders INNER JOIN shop ON orders.shop_id = shop.idWHERE orders.id = ?");
    $stmt->execute([$id]);
    $order = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT order_detail.*, food.name AS FoodName FROM order_detail JOIN food ON order_detail.food_id = food.id WHERE order_detail.id = ?");
    $stmt -> execute([$id]);
    $bill = $stmt->fetchAll();

    $total = 0;

    require_once __DIR__ . './assets/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();
    ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พิมพ์ใบเสร็จที่ <?= $id ?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/main.css">

    <style>
        body{
            font-family: 'Garuda';
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <div class="bill-header">
            <h5 class="fw-bold text-primary" style="font-weight: bold;">ใบเสร็จชำระเงิน</h5>
            <p>ร้าน <?= $order['shop_name']?> ขอขอบคุณสำหรับการสั่งซื้อ</p>
        </div>

        <div class="mt-4">
            <h4>วันที่</h4>
            <small class="text-secondary" style="color:gray;"><?= $order['date'] ?></small>
        </div>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ชื่อรายการ</th>
                    <th>จำนวน</th>
                    <th>ราคา</th>
                    <th>ส่วนลด</th>
                    <th>ราคารวม</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($bill as $data) :
                    $disss = $data['qty'] * $data['price'] * $data['discount'] / 100;
                    $total = $data['qty'] * $data['price'] - $disss;
                    $all += $total;
                ?>
                <tr>
                    <td><?= $data['FoodName'] ?></td>
                    <td><?= $data['qty'] ?></td>
                    <td><?= $data['price'] ?></td>
                    <td><?= number_format($disss, 2); ?></td>
                    <td><?= number_format($total, 2); ?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
            <tfoot>
                <tr>

                    <td colspan="5" class="text-end">
                        <?php 
                            echo number_format($all, 2);
                        ?>
                        บาท
                    </td>
                </tr>
            </tfoot>
        </table>
        <p class="text-center mt-5" style="color: gray;">&copy; 2025 <?= $order['shop_name']?></p>
    </div>
</body>
</html>


<?php
    $html = ob_get_contents();
    ob_end_clean();
    $mpdf->WriteHTML($html);
    $mpdf->Output("bill$id.pdf", 'i');
?>