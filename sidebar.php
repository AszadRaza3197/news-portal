<?php
$sqlc = "select * from category";
$resultc = mysqli_query($conn, $sqlc);

$sqll = "select * from location";
$resultl = mysqli_query($conn, $sqll);
?>



<!-- Location Start -->
<div class="card border-0 shadow-sm rounded mb-4 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="m-0 text-uppercase font-weight-bold text-primary">Location</h5>
    </div>
    <div class="card-body p-3">
        <div class="d-flex flex-wrap">
            <?php foreach ($resultl as $row) { ?>
                <a href="index.php?locat=<?php echo urlencode($row['location']); ?>" class="text-decoration-none mr-2 mb-2">
                    <span class="badge badge-light border text-dark font-weight-medium px-3 py-2 rounded-pill shadow-sm hover-effect">
                        <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                        <?php echo $row['location']; ?>
                    </span>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Location End -->

<!-- Category Start -->
<div class="card border-0 shadow-sm rounded mb-4 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="m-0 text-uppercase font-weight-bold text-primary">Category</h5>
    </div>
    <div class="card-body p-3">
        <div class="d-flex flex-wrap">
            <?php foreach ($resultc as $row) { ?>
                <a href="index.php?catcat=<?php echo urlencode($row['category']); ?>" class="text-decoration-none mr-2 mb-2">
                    <span class="badge badge-primary font-weight-medium px-3 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-folder mr-1"></i>
                        <?php echo $row['category']; ?>
                    </span>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Category End -->

<!-- Ads Start -->
<div class="card border-0 shadow-sm rounded mb-4 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="m-0 text-uppercase font-weight-bold text-secondary">Advertisement</h5>
    </div>
    <div class="card-body text-center p-3 bg-light">
        <a href="#" class="d-block overflow-hidden rounded">
            <img class="img-fluid rounded shadow-sm" src="img/news-800x500-2.jpg" alt="Advertisement">
        </a>
    </div>
</div>
<!-- Ads End -->