<?php
$conn = mysqli_connect("localhost", "root", "", "news");
if (!isset($nid)) {
    if (isset($_GET['nid'])) {
        $nid = $_GET['nid'];
    } else {
        header("Location: index.php");
        exit;
    }
}
include 'header.php';
?>

<style>
    /* Custom Visual Enhancements for Single News View */
    .news-detail-img {
        max-height: 450px;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
    }

    .action-btn {
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .action-btn:hover {
        transform: scale(1.08);
    }

    .comment-box {
        border-radius: 8px;
        background-color: #f8f9fa;
        transition: box-shadow 0.2s ease;
    }

    .comment-box:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .author-avatar {
        object-fit: cover;
        border: 2px solid #e9ecef;
    }
</style>

<div class="container-fluid py-4 bg-light">
    <div class="container">
        <div class="row">
            <!-- Main Content Area -->
            <div class="col-lg-8 mb-4">
                <?php
                $sql = "SELECT * FROM news_table INNER JOIN category ON news_table.n_category_id = category.cat_id LEFT JOIN user_details ON news_table.reporter_id = user_details.uid WHERE news_table.is_publish = 1 AND news_table.is_delete = 0 AND news_table.nid = '$nid' ORDER BY news_table.nid DESC";
                $result = mysqli_query($conn, $sql);
                ?>

                <?php foreach ($result as $row) { ?>
                    <?php $news_id = $row['nid']; ?>

                    <div class="card border-0 shadow-sm rounded overflow-hidden mb-4">
                        <!-- Featured Image -->
                        <div class="position-relative">
                            <img class="img-fluid w-100 news-detail-img" src="<?php echo $row['news_image']; ?>" alt="News Image">
                            <div class="position-absolute" style="top: 15px; left: 15px;">
                                <span class="badge badge-primary text-uppercase px-3 py-2 font-weight-bold shadow-sm">
                                    <?php echo $row['category']; ?>
                                </span>
                            </div>
                        </div>

                        <!-- Article Content Body -->
                        <div class="card-body p-4 p-md-5 bg-white">
                            <div class="mb-3 d-flex align-items-center text-muted small">
                                <i class="far fa-calendar-alt mr-2 text-primary"></i>
                                <span><?php echo $row['posted_date']; ?></span>
                            </div>

                            <h1 class="h2 mb-4 text-dark font-weight-bold" style="line-height: 1.3;">
                                <?php echo $row['heading']; ?>
                            </h1>

                            <hr class="my-4">

                            <div class="article-description text-secondary" style="font-size: 1.05rem; line-height: 1.8;">
                                <?php echo nl2br($row['description']); ?>
                            </div>
                        </div>

                        <!-- Reporter & Action Footer -->
                        <div class="card-footer bg-white border-top p-3 px-md-4 d-flex justify-content-between align-items-center flex-wrap">
                            <!-- Reporter Details -->
                            <div class="d-flex align-items-center my-1">
                                <img src="<?php echo $row['photo']; ?>" class="rounded-circle mr-3 author-avatar" width="42" height="42" alt="Reporter">
                                <div>
                                    <small class="text-muted d-block leading-none">Reported By</small>
                                    <span class="font-weight-bold text-dark"><?php echo $row['name']; ?></span>
                                </div>
                            </div>

                            <!-- Actions (Likes, Comments, Bookmarks) -->
                            <div class="d-flex align-items-center my-1 font-weight-bold">
                                <?php
                                // Comment Count Logic
                                $sql_comment = "SELECT COUNT(com_id) AS total_comment FROM comment WHERE news_id='$news_id'";
                                $result_comment = mysqli_query($conn, $sql_comment);
                                $comment = mysqli_fetch_assoc($result_comment);

                                // Like Logic
                                $sql_like = "SELECT COUNT(like_id) AS total_like FROM likes WHERE news_id='$news_id'";
                                $result_like = mysqli_query($conn, $sql_like);
                                $like = mysqli_fetch_assoc($result_like);

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

                                <!-- Comment Icon -->
                                <span class="mr-4 text-muted d-inline-flex align-items-center">
                                    <i class="far fa-comment fa-lg mr-2 text-primary"></i>
                                    <?php echo $comment['total_comment']; ?>
                                </span>

                                <!-- Like Button -->
                                <?php if ($already_like) { ?>
                                    <span class="text-primary mr-4 action-btn d-inline-flex align-items-center">
                                        <i class="fas fa-thumbs-up fa-lg mr-2"></i>
                                        <?php echo $like['total_like']; ?>
                                    </span>
                                <?php } else { ?>
                                    <a href="db.php?like=<?php echo $news_id; ?>" class="text-dark mr-4 text-decoration-none action-btn d-inline-flex align-items-center">
                                        <i class="far fa-thumbs-up fa-lg mr-2"></i>
                                        <?php echo $like['total_like']; ?>
                                    </a>
                                <?php } ?>

                                <!-- Bookmark Button -->
                                <?php
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
                                    <a href="db.php?unbook=1&Id=<?php echo $news_id; ?>" class="text-warning action-btn" title="Remove Bookmark">
                                        <i class="fas fa-bookmark fa-lg"></i>
                                    </a>
                                <?php } else { ?>
                                    <a href="db.php?book=1&Id=<?php echo $news_id; ?>" class="text-secondary action-btn" title="Bookmark">
                                        <i class="far fa-bookmark fa-lg"></i>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- Comment Form Section -->
                <div class="card border-0 shadow-sm rounded p-4 mb-4 bg-white">
                    <h4 class="font-weight-bold mb-3 border-left border-primary pl-3 border-width-4">Leave a Comment</h4>

                    <?php if (isset($_SESSION['uid']) && $_SESSION['role'] == "member") { ?>
                        <form action="db.php" method="POST">
                            <input type="hidden" name="news_id" value="<?php echo $news_id; ?>">
                            <div class="form-group mb-3">
                                <textarea name="comment" class="form-control border shadow-none p-3" rows="4" placeholder="Write your thoughts here..." style="border-radius: 8px; resize: none;" required></textarea>
                            </div>
                            <button type="submit" name="add_comment" class="btn btn-primary px-4 py-2 font-weight-bold rounded-pill shadow-sm">
                                <i class="fas fa-paper-plane mr-2"></i>Post Comment
                            </button>
                        </form>
                    <?php } else { ?>
                        <div class="alert alert-warning border-0 shadow-sm rounded mb-0" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i> Only registered members can post comments.
                        </div>
                    <?php } ?>
                </div>

                <!-- Existing Comments List Section -->
                <div class="card border-0 shadow-sm rounded p-4 bg-white">
                    <h4 class="font-weight-bold mb-4 border-left border-primary pl-3 border-width-4">
                        Comments (<?php echo $comment['total_comment']; ?>)
                    </h4>

                    <?php
                    $sql_comments = "SELECT comment.*, user_details.name, user_details.photo FROM comment INNER JOIN user_details ON comment.user_id = user_details.uid WHERE comment.news_id='$news_id' ORDER BY comment.com_id DESC";
                    $res = mysqli_query($conn, $sql_comments);

                    if (mysqli_num_rows($res) > 0) {
                        foreach ($res as $com) {
                    ?>
                            <div class="media comment-box p-3 mb-3 border-0">
                                <img src="<?php echo $com['photo']; ?>" class="rounded-circle mr-3 author-avatar" width="50" height="50" alt="User Avatar">
                                <div class="media-body">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="m-0 font-weight-bold text-dark"><?php echo $com['name']; ?></h6>
                                        <small class="text-muted"><i class="far fa-clock mr-1"></i><?php echo $com['date']; ?></small>
                                    </div>
                                    <p class="m-0 text-secondary" style="font-size: 0.95rem;">
                                        <?php echo $com['comments']; ?>
                                    </p>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <p class="text-muted mb-0">No comments yet. Be the first to share your thoughts!</p>
                    <?php } ?>
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="col-lg-4">
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>