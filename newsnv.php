<?php

$uid = $_SESSION['uid'];
$eid = $_SESSION['uid'];
$lid = $_SESSION['lid'];
$cid = $_SESSION['cid'];
$role = $_SESSION['role'];

$sql = "SELECT * FROM user_details WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_array($result);

include "editor_header.php";

$sql2 = "SELECT 
            news_table.*,
            category.category,
            location.location,
            user_details.name AS reporter_name
         FROM news_table
         INNER JOIN category ON news_table.n_category_id = category.cat_id
         INNER JOIN location ON news_table.n_location_id = location.loc_id 
         INNER JOIN user_details
         ON news_table.reporter_id = user_details.uid
         WHERE news_table.is_delete = 0
         AND category.is_delete = 0
         AND location.is_delete = 0
         AND news_table.is_publish = 0
         AND news_table.n_category_id = '$cid'
         AND news_table.n_location_id = '$lid'
         ORDER BY news_table.posted_date DESC";
$result2 = mysqli_query($conn, $sql2);
?>
<div class="container-fluid mt-4">
    <h1 class="text-center text-danger mb-4">
        <i class="fa fa-newspaper-o"></i>
        Unpublished News
    </h1>
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped mb-0">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>Heading</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Posted Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result2 as $row) { ?>
                            <?php
                            if ($row['is_publish'] == 1) {
                                $status = '<span class="badge badge-success">Published</span>';
                            } elseif ($row['is_scheduled'] == 1) {
                                $status = '<span class="badge badge-primary"><i class="fa fa-clock-o"></i>Scheduled</span>';
                            } else {
                                $status = '<span class="badge badge-warning text-dark">Unpublished</span> ';
                            }
                            ?>
                            <tr>
                                <td class="align-middle font-weight-bold">
                                    <?php echo $row['heading']; ?>
                                </td>
                                <td class="text-center align-middle">
                                    <img src="<?php echo $row['news_image']; ?>" class="img-thumbnail rounded" width="100">
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge badge-info px-3 py-2">
                                        <?php echo $row['category']; ?>
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge badge-primary px-3 py-2">
                                        <?php echo $row['location']; ?>
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <a href="db.php?vnid=<?php echo $row['nid']; ?>" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                        View
                                    </a>
                                </td>
                                <td class="text-center align-middle">
                                    <?php echo $status; ?>
                                </td>
                                <td class="text-center align-middle">
                                    <a href="db.php?publish=<?php echo $row['nid']; ?>"
                                        class="btn btn-success btn-sm mb-1">
                                        <i class="fa fa-check"></i>
                                        Publish
                                    </a>
                                    <br>
                                    <!-- DELETE -->
                                    <a href="db.php?delnews=<?php echo $row['nid']; ?>"
                                        class="btn btn-danger btn-sm mb-1"
                                        onclick="return confirm('Are you sure you want to delete this news?')">
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php
                        if (mysqli_num_rows($result2) == 0) {
                        ?>
                            <tr>
                                <td colspan="8"
                                    class="text-center text-muted py-4">
                                    <i class="fa fa-newspaper-o fa-2x"></i>
                                    <br>
                                    No unpublished news found.
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>