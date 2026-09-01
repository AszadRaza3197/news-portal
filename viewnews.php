<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($conn)) {
    $conn = mysqli_connect("localhost", "root", "", "news");
}
$uid = $_SESSION['uid'] ?? 0;
$eid = $_SESSION['uid'] ?? 0;
$lid = $_SESSION['lid'] ?? 1;
$cid = $_SESSION['cid'] ?? 1;
$role = $_SESSION['role'] ?? '';
$nid = isset($nid) ? intval($nid) : (isset($_GET['nid']) ? intval($_GET['nid']) : 0);

$sql = "select * from user_details
 INNER JOIN category ON user_details.cat_id=category.cat_id
 INNER JOIN location ON user_details.loc_id=location.loc_id where uid='$uid'";
$result = mysqli_query($conn, $sql);
$arr = $result ? mysqli_fetch_array($result) : null;
if ($role == 'admin') {
    include "admin_header.php";
} elseif ($role == 'editor') {
    include "editor_header.php";
} elseif ($role == 'reporter') {
    include "reporter_header.php";
} elseif ($role == 'member') {
    include "member_header.php";
} else {
    include "header.php";
}

if ($lid == 1 && $cid == 1) {
    $sql2 = "select * from news_table 
            INNER JOIN location ON news_table.n_location_id=location.loc_id
            INNER JOIN category ON news_table.n_category_id=category.cat_id
            INNER JOIN user_details ON news_table.reporter_id=user_details.uid
           where nid='$nid'";
    $result2 = mysqli_query($conn, $sql2);
} else {
    $sql2 = "select * from news_table 
        INNER JOIN location ON news_table.n_location_id=location.loc_id
        INNER JOIN category ON news_table.n_category_id=category.cat_id
        INNER JOIN user_details ON news_table.reporter_id=user_details.uid
        where news_table.n_category_id='$cid' and news_table.n_location_id='$lid' and nid='$nid'";
    $result2 = mysqli_query($conn, $sql2);
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php foreach($result2 as $row2){ ?>
            <div class="card">
                <div class="card-header">
                    <h3><?php echo $row2['heading'] ?></h3>
                </div>
                <div class="card-body">
                    <img src="<?php echo $row2['news_image']; ?>"class="card-img-top img-fluid" style="object-fit: cover; height: 300px;" alt="">
                </div>
                <div class="card-body">
                   <p><?php echo $row2['description'] ?></p>
                   <p>reported by: <?php echo $row2['name']?></p>
                   <p>department:<?php echo $row2['category'] ?></p>
                   <p>location:<?php echo $row2['location'] ?></p>
                </div>
                
            </div>
            <?php }?>
        </div>
    </div>
</div>



<?php
include "footer.php";
?>