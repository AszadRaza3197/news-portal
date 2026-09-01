<?php
$uid = $_SESSION['uid'];
$eid = $_SESSION['uid'];
$lid = $_SESSION['lid'];
$cid = $_SESSION['cid'];
$role = $_SESSION['role'];

// User Details
$sql = "SELECT * FROM user_details WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_array($result);

// Reporter Header
include "reporter_header.php";

// My News
$sql2 = "SELECT * FROM news_table 
INNER JOIN category ON news_table.n_category_id = category.cat_id 
INNER JOIN location ON news_table.n_location_id = location.loc_id 
WHERE news_table.is_delete = 0 AND category.is_delete = 0 AND location.is_delete = 0 AND news_table.reporter_id = '$uid' 
ORDER BY news_table.nid DESC";

$result2 = mysqli_query($conn, $sql2);
?>

<div class="container mt-4">
    <div class="card shadow border-primary">
        <!-- Card Header -->
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fa fa-newspaper"></i> My News</h3>
                <?php if (isset($_GET['msg'])) { ?>
                    <h5 class="mb-0 text-warning"><?php echo $_GET['msg']; ?></h5>
                <?php } ?>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped mb-0">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result2 as $row) { ?>
                            <?php
                            if ($row['is_scheduled'] == 1) {
                                $status = '<span class="badge badge-info"><i class="fa fa-clock"></i> Scheduled</span><br><small class="text-muted">' . date("d M Y h:i A", strtotime($row['scheduled_publish_at'])) . '</small>';
                            } elseif ($row['is_publish'] == 1) {
                                $status = '<span class="badge badge-success"><i class="fa fa-check"></i> Published</span>';
                            } else {
                                $status = '<span class="badge badge-warning text-dark"><i class="fa fa-clock"></i> Unpublished</span>';
                            }
                            ?>
                            <!-- News Row -->
                            <tr>
                                <!-- Title -->
                                <td class="align-middle font-weight-bold"><?php echo $row['heading']; ?></td>

                                <!-- Image -->
                                <td class="text-center align-middle">
                                    <img src="<?php echo $row['news_image']; ?>" class="img-thumbnail rounded" width="100">
                                </td>

                                <!-- Category -->
                                <td class="text-center align-middle">
                                    <span class="badge badge-info px-3 py-2"><?php echo $row['category']; ?></span>
                                </td>

                                <!-- Location -->
                                <td class="text-center align-middle">
                                    <span class="badge badge-primary px-3 py-2"><?php echo $row['location']; ?></span>
                                </td>

                                <!-- Description -->
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#description<?php echo $row['nid']; ?>">
                                        <i class="fa fa-eye"></i> View
                                    </button>
                                </td>

                                <!-- Posted Date -->
                                <td class="text-center align-middle"><?php echo date("d M Y", strtotime($row['posted_date'])); ?></td>

                                <!-- Status -->
                                <td class="text-center align-middle"><?php echo $status; ?></td>

                                <!-- Action -->
                                <td class="text-center align-middle">
                                    <a href="db.php?delnews=<?php echo $row['nid']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this news?')">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>

                            <!-- Description Modal -->
                            <div class="modal fade" id="description<?php echo $row['nid']; ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title"><?php echo $row['heading']; ?></h5>
                                            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <!-- Modal Body -->
                                        <div class="modal-body"><?php echo nl2br($row['description']); ?></div>
                                        <!-- Modal Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>