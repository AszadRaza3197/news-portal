<?php
require "db.php";

if (!isset($_SESSION['uid'])) {
    header("Location: signin.php");
    exit;
}

$uid  = $_SESSION['uid'];
$role = $_SESSION['role'];

// Role-based headers
switch ($role) {
    case "admin":
        require "admin_header.php";
        break;
    case "editor":
        require "editor_header.php";
        break;
    case "reporter":
        require "reporter_header.php";
        break;
    case "member":
        require "member_header.php";
        break;
    default:
        header("Location: signin.php");
        exit;
}

/* User Details */
$sql    = "SELECT * FROM user_details WHERE uid = '$uid'";
$result = mysqli_query($conn, $sql);
$user   = mysqli_fetch_assoc($result);

/* Data Fetching Logic */
if ($role == "admin") {

    $total_users = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_details WHERE is_deleted = 0")
    )['total'];

    $total_news = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM news_table WHERE is_delete = 0")
    )['total'];

    $published_news = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM news_table WHERE is_publish = 1 AND is_delete = 0")
    )['total'];

    $pending_news = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM news_table WHERE is_publish = 0 AND is_delete = 0")
    )['total'];

    $total_category = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM category")
    )['total'];

    $total_location = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM location")
    )['total'];


    // Total Comments
    $total_comments = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM comment")
    )['total'];


    // Total Editors
    $total_editors = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_details WHERE role = 'editor' AND is_deleted = 0")
    )['total'];


    // Total Reporters
    $total_reporters = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_details WHERE role = 'reporter' AND is_deleted = 0")
    )['total'];


    // Total Members
    $total_members = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_details WHERE role = 'member' AND is_deleted = 0")
    )['total'];


    // Total Likes
    $total_likes = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM likes")
    )['total'];


    // Total Views
    $total_views = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT SUM(views) AS total FROM news_table")
    )['total'];

    if ($total_views == NULL) {
        $total_views = 0;
    }
} elseif ($role == "editor") {
    $total_news     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM news_table WHERE editor_id = '$uid' AND is_delete = 0"))['total'];
    $published_news = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM news_table WHERE editor_id = '$uid' AND is_publish = 1 AND is_delete = 0"))['total'];
    $pending_news   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM news_table WHERE editor_id = '$uid' AND is_publish = 0 AND is_delete = 0"))['total'];
} elseif ($role == "reporter") {
    $total_news     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM news_table WHERE reporter_id = '$uid' AND is_delete = 0"))['total'];
    $published_news = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM news_table WHERE reporter_id = '$uid' AND is_publish = 1 AND is_delete = 0"))['total'];
    $pending_news   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM news_table WHERE reporter_id = '$uid' AND is_publish = 0 AND is_delete = 0"))['total'];
} elseif ($role == "member") {

    // Total Comments
    $total_comments = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM comment WHERE user_id = '$uid'")
    )['total'];

    // Total Likes
    $total_likes = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM likes WHERE user_id = '$uid'")
    )['total'];

    // Total Bookmarks
    $total_bookmarks = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookmark WHERE user_id = '$uid'")
    )['total'];
}
?>

<div class="container py-4">

    <!-- Profile & Header Section -->
    <div class="card shadow-sm border-0 mb-4 bg-light">
        <div class="card-body p-3">
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <?php if (!empty($user['photo'])) { ?>
                        <img src="<?php echo htmlspecialchars($user['photo']); ?>" alt="Profile" class="rounded-circle img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                    <?php } else { ?>
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center text-secondary border shadow-sm" style="width: 60px; height: 60px;">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                    <?php } ?>
                </div>
                <div>
                    <h4 class="mb-0 font-weight-bold">
                        Welcome, <?php echo htmlspecialchars($user['name']); ?>
                    </h4>
                    <span class="badge badge-primary mt-1 px-3 py-1">
                        <?php echo ucfirst($role); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Title -->
    <div class="d-flex align-items-center mb-4">
        <h4 class="font-weight-bold text-dark mb-0">
            <?php
            if ($role == "admin") echo '<i class="fas fa-tachometer-alt text-primary mr-2"></i> Admin Dashboard';
            elseif ($role == "editor") echo '<i class="fas fa-edit text-warning mr-2"></i> Editor Dashboard';
            elseif ($role == "reporter") echo '<i class="fas fa-user-edit text-info mr-2"></i> Reporter Dashboard';
            elseif ($role == "member") echo '<i class="fas fa-user text-success mr-2"></i> Member Dashboard';
            ?>
        </h4>
    </div>

    <!-- Cards Grid Section -->
    <div class="row">

        <?php if ($role == "admin") { ?>
            <!-- Total Users -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-primary text-white mr-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">Total Users</p>
                            <h3 class="font-weight-bold mb-0"><?php echo $total_users; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total News -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-info text-white mr-3">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">Total News</p>
                            <h3 class="font-weight-bold mb-0"><?php echo $total_news; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Published News -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-success text-white mr-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">Published News</p>
                            <h3 class="font-weight-bold mb-0"><?php echo $published_news; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending News -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-warning text-white mr-3">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">Pending News</p>
                            <h3 class="font-weight-bold mb-0"><?php echo $pending_news; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Categories -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-secondary text-white mr-3">
                            <i class="fas fa-list fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">Total Categories</p>
                            <h3 class="font-weight-bold mb-0"><?php echo $total_category; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Locations -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-dark text-white mr-3">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">Total Locations</p>
                            <h3 class="font-weight-bold mb-0"><?php echo $total_location; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Likes -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-danger text-white mr-3">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">
                                Total Likes
                            </p>
                            <h3 class="font-weight-bold mb-0">
                                <?php echo $total_likes; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Total Comments -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-primary text-white mr-3">
                            <i class="fas fa-comments fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">
                                Total Comments
                            </p>
                            <h3 class="font-weight-bold mb-0">
                                <?php echo $total_comments; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Total Views -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-info text-white mr-3">
                            <i class="fas fa-eye fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">
                                Total Views
                            </p>
                            <h3 class="font-weight-bold mb-0">
                                <?php echo $total_views; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Total Editors -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-warning text-white mr-3">
                            <i class="fas fa-user-edit fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">
                                Total Editors
                            </p>
                            <h3 class="font-weight-bold mb-0">
                                <?php echo $total_editors; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Total Reporters -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-success text-white mr-3">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">
                                Total Reporters
                            </p>
                            <h3 class="font-weight-bold mb-0">
                                <?php echo $total_reporters; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Total Members -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-secondary text-white mr-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">
                                Total Members
                            </p>
                            <h3 class="font-weight-bold mb-0">
                                <?php echo $total_members; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($role == "editor" || $role == "reporter") { ?>
            <!-- Assigned / My News -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-info text-white mr-3">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">
                                <?php echo ($role == "editor") ? "Assigned News" : "My News"; ?>
                            </p>
                            <h3 class="font-weight-bold mb-0"><?php echo $total_news; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Published News -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-success text-white mr-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">Published News</p>
                            <h3 class="font-weight-bold mb-0"><?php echo $published_news; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending News -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-warning text-white mr-3">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">Pending News</p>
                            <h3 class="font-weight-bold mb-0"><?php echo $pending_news; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($role == "member") { ?>

            <!-- Total Comments -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-primary text-white mr-3">
                            <i class="fas fa-comments fa-2x"></i>
                        </div>

                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">
                                Total Comments
                            </p>

                            <h3 class="font-weight-bold mb-0">
                                <?php echo $total_comments; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Total Likes -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-danger text-white mr-3">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>

                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">
                                Total Likes
                            </p>

                            <h3 class="font-weight-bold mb-0">
                                <?php echo $total_likes; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Total Bookmarks -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded p-3 bg-warning text-white mr-3">
                            <i class="fas fa-bookmark fa-2x"></i>
                        </div>

                        <div>
                            <p class="text-muted mb-0 small text-uppercase font-weight-bold">
                                Total Bookmarks
                            </p>

                            <h3 class="font-weight-bold mb-0">
                                <?php echo $total_bookmarks; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>
</div>

<?php
include "footer.php";
?>