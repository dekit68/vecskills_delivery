<?php foreach($listFood as $data): ?>
<?php 
    $stmt = $pdo->prepare("SELECT review.*, CONCAT(users.fname, ' ',users.lname) AS username FROM review JOIN users ON review.user_id = users.id WHERE review.food_id = ?");
    $stmt->execute([$data['id']]);
    $review = $stmt->fetchAll();
?>
<div class="contents" id="review-<?= $data['id'] ?>">
    <div class="container py-5">
    <h1>รีวิว <?= $data['name'] ?></h1>    
    <div class="mt-4 food-item" data-foodtype="<?= $data['type_id'] ?>"
        data-shopname="<?= $data['shop_id'] ?>">
        <div class="card">
            <div class="d-flex justify-content-center">
                <img src="<?= $data['food_img'] ?>" class="card-img-top" style="width: auto; height: 200px;">
            </div>

            <div class="card-body">
                <h5 class="card-title">
                    <?= $data['name'] ?>
                </h5>
                <p class="card-text text-secondary">
                    <?= $data['foodtype'] ?> | ร้าน <?= $data['shopname'] ?>
            
                </p>

                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-success fw-bold"><?= $data['price'] ?>บาท</small>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <?php foreach ($review as $data2) : ?>
    <div class="mt-4" >
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <?= $data2['username'] ?>
                </h5>
                <p class="card-text text-secondary">
                    <?= $data2['comment'] ?>
                </p>

                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-warning fw-bold"><?= $data2['star'] ?> Star</small>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <form action="core/user.php?type=review" method="post">
        <div class="row mt-3">
            <div class="col">
                <div class="form-floating">
                    <input type="text" name="message" placeholder="s" class="form-control" required>
                    <label>Message</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <select name="star" class="form-control">
                        <option value="5">5</option>
                        <option value="4">4</option>
                        <option value="3">3</option>
                        <option value="2">2</option>
                        <option value="1">1</option>
                    </select>
                    <label>Star</label>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <button class="btn btn-primary btn-lg w-100 mt-3">รีวิว</button>
    </form>
    </div>
</div>
<?php endforeach; ?>