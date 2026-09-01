<?php
include "header.php";

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "news");
// Auto-publish scheduled news whose scheduled time has arrived
mysqli_query($conn, "UPDATE news_table SET is_publish = 1, is_scheduled = 0 WHERE is_scheduled = 1 AND scheduled_publish_at IS NOT NULL AND scheduled_publish_at <= NOW() AND is_delete = 0");


// Query 1: Breaking & Published News (Slider)
$sql = "SELECT * FROM news_table
        INNER JOIN category ON news_table.n_category_id = category.cat_id
        WHERE news_table.is_breaking = 1 AND news_table.is_publish = 1 AND news_table.is_delete = 0 AND category.is_delete = 0";
$result = mysqli_query($conn, $sql);

// Query 2: Category 2 Latest
$sql1 = "SELECT * FROM news_table
         INNER JOIN category ON news_table.n_category_id = category.cat_id
         WHERE news_table.is_publish = 1 AND news_table.is_delete = 0 AND news_table.is_publish = 1 AND category.is_delete = 0 AND news_table.n_category_id = 2 
         ORDER BY news_table.nid DESC LIMIT 1";
$result1 = mysqli_query($conn, $sql1);

// Query 3: Category 3 Latest
$sql2 = "SELECT * FROM news_table
         INNER JOIN category ON news_table.n_category_id = category.cat_id
         WHERE news_table.is_publish = 1 AND news_table.is_delete = 0 AND news_table.is_publish = 1 AND category.is_delete = 0 AND news_table.n_category_id = 3 
         ORDER BY news_table.nid DESC LIMIT 1";
$result2 = mysqli_query($conn, $sql2);

// Query 4: Category 4 Latest
$sql3 = "SELECT * FROM news_table
         INNER JOIN category ON news_table.n_category_id = category.cat_id
         WHERE news_table.is_publish = 1 AND news_table.is_delete = 0 AND news_table.is_publish = 1 AND category.is_delete = 0 AND news_table.n_category_id = 4 
         ORDER BY news_table.nid DESC LIMIT 1";
$result3 = mysqli_query($conn, $sql3);

// Query 5: Category 5 Latest
$sql4 = "SELECT * FROM news_table
         INNER JOIN category ON news_table.n_category_id = category.cat_id
         WHERE news_table.is_publish = 1 AND news_table.is_delete = 0 AND news_table.is_publish = 1 AND category.is_delete = 0 AND news_table.n_category_id = 5 
         ORDER BY news_table.nid DESC LIMIT 1";
$result4 = mysqli_query($conn, $sql4);


if (isset($_GET['nid'])) {
    $nid = intval($_GET['nid']);
}

// Location / Category Filter & Search Logic
if (isset($_GET['locat']) || isset($_GET['catcat']) || isset($_POST['keyword'])) {
    if (!empty($_GET['locat']) && empty($_GET['catcat'])) {
        $locat = mysqli_real_escape_string($conn, $_GET['locat']);
        if ($locat == 'all') {
            $sql6 = "SELECT * FROM news_table
                    INNER JOIN category ON news_table.n_category_id = category.cat_id
                    INNER JOIN user_details ON news_table.reporter_id = user_details.uid
                    INNER JOIN location ON news_table.n_location_id = location.loc_id
                    WHERE news_table.is_publish = 1 AND news_table.is_delete = 0
                    ORDER BY news_table.nid DESC
                    LIMIT 8";
            $result5 = mysqli_query($conn, $sql6);
        } else {
            $sql6 = "SELECT * FROM news_table
                    INNER JOIN category ON news_table.n_category_id = category.cat_id
                    INNER JOIN user_details ON news_table.reporter_id = user_details.uid
                    INNER JOIN location ON news_table.n_location_id = location.loc_id
                    WHERE news_table.is_publish = 1 
                    AND news_table.is_delete = 0 
                    AND location.location = '$locat'
                    ORDER BY news_table.nid DESC
                    LIMIT 8";
            $result5 = mysqli_query($conn, $sql6);
        }
    } elseif (empty($_GET['locat']) && !empty($_GET['catcat'])) {
        $catcat = mysqli_real_escape_string($conn, $_GET['catcat']);
        if ($catcat == 'all') {
            $sql6 = "SELECT * FROM news_table
                    INNER JOIN category ON news_table.n_category_id = category.cat_id
                    INNER JOIN user_details ON news_table.reporter_id = user_details.uid
                    INNER JOIN location ON news_table.n_location_id = location.loc_id
                    WHERE news_table.is_publish = 1 AND news_table.is_delete = 0
                    ORDER BY news_table.nid DESC
                    LIMIT 8";
            $result5 = mysqli_query($conn, $sql6);
        } else {
            $sql6 = "SELECT * FROM news_table
                    INNER JOIN category ON news_table.n_category_id = category.cat_id
                    INNER JOIN user_details ON news_table.reporter_id = user_details.uid
                    INNER JOIN location ON news_table.n_location_id = location.loc_id
                    WHERE news_table.is_publish = 1 
                    AND news_table.is_delete = 0 
                    AND category.category = '$catcat'
                    ORDER BY news_table.nid DESC
                    LIMIT 8";
            $result5 = mysqli_query($conn, $sql6);
        }
    } elseif (!empty($_GET['locat']) && !empty($_GET['catcat'])) {
        $locat = mysqli_real_escape_string($conn, $_GET['locat']);
        $catcat = mysqli_real_escape_string($conn, $_GET['catcat']);
        $sql6 = "SELECT * FROM news_table
                INNER JOIN category ON news_table.n_category_id = category.cat_id
                INNER JOIN user_details ON news_table.reporter_id = user_details.uid
                INNER JOIN location ON news_table.n_location_id = location.loc_id
                WHERE news_table.is_publish = 1 
                AND news_table.is_delete = 0 
                AND location.location = '$locat' 
                AND category.category = '$catcat'
                ORDER BY news_table.nid DESC
                LIMIT 8";
        $result5 = mysqli_query($conn, $sql6);
    } elseif (!empty($_POST['keyword'])) {
        $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
        $sql6 = "SELECT * FROM news_table
                INNER JOIN category ON news_table.n_category_id = category.cat_id
                INNER JOIN user_details ON news_table.reporter_id = user_details.uid
                INNER JOIN location ON news_table.n_location_id = location.loc_id
                WHERE news_table.is_publish = 1 
                AND news_table.is_delete = 0 
                AND (news_table.heading LIKE '%$keyword%' OR news_table.description LIKE '%$keyword%')
                ORDER BY news_table.nid DESC";
        $result5 = mysqli_query($conn, $sql6);
    }
} else {
    // Default Query for Latest News
    $sql5 = "SELECT * FROM news_table
            INNER JOIN category ON news_table.n_category_id = category.cat_id
            INNER JOIN user_details ON news_table.reporter_id = user_details.uid
            INNER JOIN location ON news_table.n_location_id = location.loc_id
            WHERE news_table.is_publish = 1 AND news_table.is_delete = 0
            ORDER BY news_table.nid DESC
            LIMIT 8";
    $result5 = mysqli_query($conn, $sql5);
}

$sqlc = "SELECT * FROM category WHERE is_delete=0";
$resultc = mysqli_query($conn, $sqlc);

$sqll = "SELECT * FROM location WHERE is_delete=0";
$resultl = mysqli_query($conn, $sqll);
?>

<style>
    /* Custom Layout Styling for Modern Look */
    .news-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .news-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12) !important;
    }

    .news-overlay {
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.4) 60%, transparent 100%);
    }

    .badge-rounded {
        border-radius: 4px;
        letter-spacing: 0.5px;
    }
</style>
<!-- Main News Slider Start -->
<div class="container-fluid py-4 bg-light">
    <div class="row px-lg-3">
        <!-- Main Carousel -->
        <div class="col-lg-7 px-2 mb-3 mb-lg-0">
            <div class="owl-carousel main-carousel position-relative rounded overflow-hidden shadow-sm">
                <?php foreach ($result as $row) { ?>
                    <div class="position-relative overflow-hidden" style="height: 500px;">
                        <img class="img-fluid h-100 w-100" src="<?php echo htmlspecialchars($row['news_image']); ?>" style="object-fit: cover;">
                        <div class="overlay news-overlay position-absolute w-100 p-4" style="bottom: 0;">
                            <div class="mb-2 d-flex align-items-center">
                                <a class="badge badge-primary badge-rounded text-uppercase font-weight-bold px-3 py-2 mr-2" href="index.php?catcat=<?php echo urlencode($row['category']); ?>"><?php echo htmlspecialchars($row['category']); ?></a>
                                <span class="text-white-50 small"><i class="far fa-calendar-alt mr-1"></i><?php echo date('d-m-Y', strtotime($row['posted_date'])); ?></span>
                            </div>
                            <a class="h3 m-0 text-white text-uppercase font-weight-bold d-block text-truncate text-decoration-none" href="db.php?singlenews2=<?php echo $row['nid']; ?>"><?php echo htmlspecialchars($row['heading']); ?></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Side Grids (4 Grid Items) -->
        <div class="col-lg-5 px-2">
            <div class="row mx-0">
                <!-- Block 1 -->
                <div class="col-md-6 px-1 mb-2">
                    <div class="position-relative overflow-hidden rounded shadow-sm news-card" style="height: 245px;">
                        <?php foreach ($result1 as $row1) { ?>
                            <img class="img-fluid w-100 h-100" src="<?php echo htmlspecialchars($row1['news_image']); ?>" style="object-fit: cover;">
                            <div class="overlay news-overlay position-absolute w-100 p-3" style="bottom: 0;">
                                <div class="mb-1 d-flex align-items-center">
                                    <a class="badge badge-primary badge-rounded text-uppercase font-weight-semi-bold p-1 mr-2" href="index.php?catcat=<?php echo urlencode($row1['category']); ?>"><?php echo htmlspecialchars($row1['category']); ?></a>
                                    <span class="text-white-50 small"><small><?php echo date('d-m-Y', strtotime($row1['posted_date'])); ?></small></span>
                                </div>
                                <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold d-block text-truncate text-decoration-none" href="db.php?singlenews2=<?php echo $row1['nid']; ?>"><?php echo htmlspecialchars($row1['heading']); ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Block 2 -->
                <div class="col-md-6 px-1 mb-2">
                    <div class="position-relative overflow-hidden rounded shadow-sm news-card" style="height: 245px;">
                        <?php foreach ($result2 as $row1) { ?>
                            <img class="img-fluid w-100 h-100" src="<?php echo htmlspecialchars($row1['news_image']); ?>" style="object-fit: cover;">
                            <div class="overlay news-overlay position-absolute w-100 p-3" style="bottom: 0;">
                                <div class="mb-1 d-flex align-items-center">
                                    <a class="badge badge-primary badge-rounded text-uppercase font-weight-semi-bold p-1 mr-2" href="index.php?catcat=<?php echo urlencode($row1['category']); ?>"><?php echo htmlspecialchars($row1['category']); ?></a>
                                    <span class="text-white-50 small"><small><?php echo date('d-m-Y', strtotime($row1['posted_date'])); ?></small></span>
                                </div>
                                <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold d-block text-truncate text-decoration-none" href="db.php?singlenews2=<?php echo $row1['nid']; ?>"><?php echo htmlspecialchars($row1['heading']); ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Block 3 -->
                <div class="col-md-6 px-1 mb-2 mb-md-0">
                    <div class="position-relative overflow-hidden rounded shadow-sm news-card" style="height: 245px;">
                        <?php foreach ($result3 as $row1) { ?>
                            <img class="img-fluid w-100 h-100" src="<?php echo htmlspecialchars($row1['news_image']); ?>" style="object-fit: cover;">
                            <div class="overlay news-overlay position-absolute w-100 p-3" style="bottom: 0;">
                                <div class="mb-1 d-flex align-items-center">
                                    <a class="badge badge-primary badge-rounded text-uppercase font-weight-semi-bold p-1 mr-2" href="index.php?catcat=<?php echo urlencode($row1['category']); ?>"><?php echo htmlspecialchars($row1['category']); ?></a>
                                    <span class="text-white-50 small"><small><?php echo date('d-m-Y', strtotime($row1['posted_date'])); ?></small></span>
                                </div>
                                <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold d-block text-truncate text-decoration-none" href="db.php?singlenews2=<?php echo $row1['nid']; ?>"><?php echo htmlspecialchars($row1['heading']); ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Block 4 -->
                <div class="col-md-6 px-1">
                    <div class="position-relative overflow-hidden rounded shadow-sm news-card" style="height: 245px;">
                        <?php foreach ($result4 as $row1) { ?>
                            <img class="img-fluid w-100 h-100" src="<?php echo htmlspecialchars($row1['news_image']); ?>" style="object-fit: cover;">
                            <div class="overlay news-overlay position-absolute w-100 p-3" style="bottom: 0;">
                                <div class="mb-1 d-flex align-items-center">
                                    <a class="badge badge-primary badge-rounded text-uppercase font-weight-semi-bold p-1 mr-2" href="index.php?catcat=<?php echo urlencode($row1['category']); ?>"><?php echo htmlspecialchars($row1['category']); ?></a>
                                    <span class="text-white-50 small"><small><?php echo date('d-m-Y', strtotime($row1['posted_date'])); ?></small></span>
                                </div>
                                <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold d-block text-truncate text-decoration-none" href="db.php?singlenews2=<?php echo $row1['nid']; ?>"><?php echo htmlspecialchars($row1['heading']); ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main News Slider End -->

<!-- News With Sidebar Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <!-- Latest News Main Section -->
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="section-title border-bottom pb-2 d-flex justify-content-between align-items-center">
                            <h4 class="m-0 text-uppercase font-weight-bold border-left border-primary pl-3 border-width-4">Latest News</h4>
                            <a class="btn btn-sm btn-outline-secondary font-weight-bold" href="">View All</a>
                        </div>
                    </div>

                    <?php foreach ($result5 as $row) { ?>

                        <div class="col-lg-6 mb-4">
                            <div class="card border-0 shadow-sm rounded overflow-hidden h-100 news-card">
                                <div class="position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="<?php echo $row['news_image']; ?>" style="height: 220px; object-fit: cover;">
                                </div>
                                <div class="card-body p-4">
                                    <div class="mb-2 d-flex flex-wrap align-items-center">
                                        <a class="badge badge-primary badge-rounded text-uppercase font-weight-semi-bold p-2 mr-2 mb-1" href=""><?php echo $row['category']; ?></a>
                                        <a class="badge badge-secondary badge-rounded text-uppercase font-weight-semi-bold p-2 mr-2 mb-1" href=""><?php echo $row['location']; ?></a>
                                        <span class="text-muted ml-auto small"><i class="far fa-clock mr-1"></i><?php echo date('d-m-Y', strtotime($row['posted_date'])); ?></span>
                                    </div>
                                    <a class="h5 card-title d-block mb-2 text-dark text-uppercase font-weight-bold text-truncate text-decoration-none" href="db.php?singlenews2=<?php echo $row['nid']; ?>"><?php echo substr($row['heading'], 0, 20); ?></a>
                                    <p class="card-text text-muted small mb-0" style="line-height: 1.6;"><?php echo substr($row['description'], 0, 80) . "..."; ?></p>
                                </div>
                                <div class="card-footer bg-light border-top p-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle mr-2 border" src="<?php echo $row['photo']; ?>" width="32" height="32" alt="" style="object-fit: cover;">
                                        <small class="font-weight-bold text-dark"><?php echo $row['name']; ?></small>
                                    </div>

                                    <?php
                                    // COMMENT COUNT
                                    $sql6 = "SELECT COUNT(com_id) AS comment_count FROM comment WHERE news_id='" . $row['nid'] . "'";
                                    $result6 = mysqli_query($conn, $sql6);
                                    $arr = mysqli_fetch_assoc($result6);

                                    // LIKE COUNT
                                    $news_id = $row['nid'];
                                    $sql_like = "SELECT COUNT(like_id) AS total_like FROM likes WHERE news_id='$news_id'";
                                    $result_like = mysqli_query($conn, $sql_like);
                                    $like = mysqli_fetch_assoc($result_like);

                                    // CHECK ALREADY LIKED
                                    $already_like = false;
                                    if (isset($_SESSION['uid'])) {
                                        $uid = $_SESSION['uid'];
                                        $sql_check = "SELECT like_id FROM likes WHERE user_id='$uid' AND news_id='$news_id'";
                                        $result_check = mysqli_query($conn, $sql_check);
                                        if (mysqli_num_rows($result_check) > 0) {
                                            $already_like = true;
                                        }
                                    }
                                    ?>

                                    <div class="d-flex align-items-center small">
                                        <!-- LIKE -->
                                        <?php if ($already_like) { ?>
                                            <span class="text-primary mr-3 font-weight-bold">
                                                <i class="fas fa-thumbs-up mr-1"></i><?php echo $like['total_like']; ?>
                                            </span>
                                        <?php } else { ?>
                                            <a href="db.php?like=<?php echo $news_id; ?>" class="text-muted mr-3 text-decoration-none">
                                                <i class="far fa-thumbs-up mr-1"></i><?php echo $like['total_like']; ?>
                                            </a>
                                        <?php } ?>

                                        <!-- VIEWS -->
                                        <span class="text-muted mr-3">
                                            <i class="far fa-eye mr-1"></i><?php echo $row['views']; ?>
                                        </span>

                                        <!-- COMMENTS -->
                                        <span class="text-muted mr-3">
                                            <i class="far fa-comment mr-1"></i><?php echo $arr['comment_count']; ?>
                                        </span>

                                        <!-- BOOKMARK -->
                                        <?php
                                        $news_id = $row['nid'];
                                        $is_bookmarked = false;

                                        if (isset($_SESSION['uid'])) {
                                            $uid = $_SESSION['uid'];
                                            $bookmark_sql = "SELECT bid FROM bookmark WHERE user_id='$uid' AND news_id='$news_id'";
                                            $bookmark_result = mysqli_query($conn, $bookmark_sql);

                                            if (mysqli_num_rows($bookmark_result) > 0) {
                                                $is_bookmarked = true;
                                            }
                                        }
                                        ?>

                                        <?php if ($is_bookmarked) { ?>
                                            <!-- Bookmarked = Yellow -->
                                            <a href="db.php?unbook=1&Id=<?php echo $news_id; ?>" class="text-warning" title="Remove Bookmark">
                                                <i class="fas fa-bookmark"></i>
                                            </a>
                                        <?php } else { ?>
                                            <!-- Not Bookmarked = Grey -->
                                            <a href="db.php?book=1&Id=<?php echo $news_id; ?>" class="text-secondary" title="Bookmark">
                                                <i class="far fa-bookmark"></i>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-12 text-center mt-2" id="showMoreBox">
                        <button type="button" class="btn btn-primary px-4" id="showMoreBtn">
                            Show More
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="col-lg-4">
                <?php include "sidebar.php"; ?>

                <!-- Popular News / Trending News -->
                <?php
                $sql = "SELECT * FROM news_table ORDER BY views DESC LIMIT 6";
                $res = mysqli_query($conn, $sql);
                ?>
                <div class="mb-4 mt-3">
                    <div class="section-title border-bottom pb-2 mb-3">
                        <h4 class="m-0 text-uppercase font-weight-bold border-left border-primary pl-3">Trending News</h4>
                    </div>
                    <?php
                    foreach ($res as $row) {
                        $img = $row['news_image'];
                        $sc = substr($row['heading'], 0, 20);
                        $id = $row['nid'];
                    ?>
                        <div class="card border-0 shadow-sm rounded mb-3 overflow-hidden news-card">
                            <div class="d-flex align-items-center bg-white" style="height: 90px;">
                                <img class="img-fluid" src="<?php echo $img; ?>" alt="" style="height: 90px; width: 90px; object-fit: cover;">
                                <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center">
                                    <div class="mb-1 d-flex justify-content-between align-items-center">
                                        <a class="badge badge-primary badge-rounded text-uppercase font-weight-semi-bold p-1" href="db.php?readmore=<?php echo $id; ?>">View More</a>
                                    </div>
                                    <h6 class="h6 m-0 text-dark text-uppercase font-weight-bold text-truncate"><?php echo $sc; ?></h6>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- News With Sidebar End -->
<script>
    let offset = 8;

    document.addEventListener("click", function(e) {

        if (e.target.id !== "showMoreBtn") {
            return;
        }

        let button = e.target;

        button.innerHTML = "Loading...";
        button.disabled = true;

        let formData = new FormData();

        formData.append("offset", offset);

        fetch("load_more_news.php", {
                method: "POST",
                body: formData
            })
            .then(function(response) {
                return response.text();
            })
            .then(function(data) {

                let newsContainer = document.querySelector(".col-lg-8 .row");

                let showMoreBox = document.getElementById("showMoreBox");

                if (data.trim() === '<div id="noMoreNews"></div>') {

                    showMoreBox.remove();

                    return;
                }

                showMoreBox.remove();

                newsContainer.insertAdjacentHTML("beforeend", data);

                offset = offset + 8;

                newsContainer.insertAdjacentHTML("beforeend", `
            <div class="col-12 text-center mt-2" id="showMoreBox">
                <button type="button" class="btn btn-primary px-4" id="showMoreBtn">
                    Show More
                </button>
            </div>
        `);

            });

    });
</script>



<?php
include "footer.php";
?>