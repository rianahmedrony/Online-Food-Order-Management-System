<div class="card" data-food-id="<?= $id ?>" data-tilt>
    <div class="card-img">
        <img class="food-img" src="/assets/images/foods/<?= $img ?>" alt="" />
    </div>
    <div class="card-body">
        <div class="card-title">
            <h5 class="food-name"><?= $title ?></h5>
        </div>
        <div class="card-text">
            <div class="mb-2 text-muted food-price"><?= $price ?> Taka</div>
            <button class="btn btn-primary w-100 add-to-cart">Add to cart</button>
        </div>
    </div>
</div>