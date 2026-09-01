<?php

$conn = mysqli_connect("localhost", "root", "", "news");

$offset = isset($_POST['offset']) ? $_POST['offset'] : 8;

$sql = "SELECT * FROM news_table
        INNER JOIN category ON news_table.n_category_id = category.cat_id
        INNER JOIN user_details ON news_table.reporter_id = user_details.uid
        INNER JOIN location ON news_table.n_location_id = location.loc_id
        WHERE news_table.is_publish = 1 
        AND news_table.is_delete = 0
        ORDER BY news_table.nid DESC
        LIMIT 8 OFFSET $offset";

$result = mysqli_query($conn, $sql);

$count = mysqli_num_rows($result);

foreach ($result as $row) {

    $news_id = $row['nid'];

    // Comment Count
    $sql_comment = "SELECT COUNT(com_id) AS comment_count 
                    FROM comment 
                    WHERE news_id='$news_id'";

    $result_comment = mysqli_query($conn, $sql_comment);
    $comment = mysqli_fetch_assoc($result_comment);

    // Like Count
    $sql_like = "SELECT COUNT(like_id) AS total_like 
                 FROM likes 
                 WHERE news_id='$news_id'";

    $result_like = mysqli_query($conn, $sql_like);
    $like = mysqli_fetch_assoc($result_like);

?>


    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm rounded overflow-hidden h-100 news-card">
            <div class="position-relative overflow-hidden">

                <img class="img-fluid w-100"
                    src="<?php echo $row['news_image']; ?>"
                    style="height: 220px; object-fit: cover;">

            </div>

            <div class="card-body p-4">

                <div class="mb-2 d-flex flex-wrap align-items-center">

                    <a class="badge badge-primary badge-rounded text-uppercase font-weight-semi-bold p-2 mr-2 mb-1"
                        href="">
                        <?php echo $row['category']; ?>
                    </a>

                    <a class="badge badge-secondary badge-rounded text-uppercase font-weight-semi-bold p-2 mr-2 mb-1"
                        href="">
                        <?php echo $row['location']; ?>
                    </a>

                    <span class="text-muted ml-auto small">
                        <i class="far fa-clock mr-1"></i>
                        <?php echo date('d-m-Y', strtotime($row['posted_date'])); ?>
                    </span>

                </div>

                <a class="h5 card-title d-block mb-2 text-dark text-uppercase font-weight-bold text-truncate text-decoration-none"
                    href="db.php?singlenews2=<?php echo $row['nid']; ?>">

                    <?php echo substr($row['heading'], 0, 20); ?>

                </a>

                <p class="card-text text-muted small mb-0" style="line-height: 1.6;">

                    <?php echo substr($row['description'], 0, 80) . "..."; ?>

                </p>

            </div>

            <div class="card-footer bg-light border-top p-3 d-flex justify-content-between align-items-center">

                <div class="d-flex align-items-center">

                    <img class="rounded-circle mr-2 border"
                        src="<?php echo $row['photo']; ?>"
                        width="32"
                        height="32"
                        alt=""
                        style="object-fit: cover;">

                    <small class="font-weight-bold text-dark">
                        <?php echo $row['name']; ?>
                    </small>

                </div>

                <div class="d-flex align-items-center small">

                    <span class="text-muted mr-3">
                        <i class="far fa-thumbs-up mr-1"></i>
                        <?php echo $like['total_like']; ?>
                    </span>

                    <span class="text-muted mr-3">
                        <i class="far fa-eye mr-1"></i>
                        <?php echo $row['views']; ?>
                    </span>

                    <span class="text-muted">
                        <i class="far fa-comment mr-1"></i>
                        <?php echo $comment['comment_count']; ?>
                    </span>

                </div>

            </div>

        </div>

    </div>

<?php
}

if ($count < 8) {
    echo '<div id="noMoreNews"></div>';
}
?>