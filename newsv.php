<?php
$uid = $_SESSION['uid'];
$eid = $_SESSION['uid'];
$lid = $_SESSION['lid'];
$cid = $_SESSION['cid'];
$role = $_SESSION['role'];
$sql = "select * from user_details where uid='$uid'";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_array($result);
if ($arr['role'] == 'admin') {
    include "admin_header.php";
} elseif ($arr['role'] == 'editor') {
    include "editor_header.php";
} elseif ($arr['role'] == 'reporter') {
    include "reporter_header.php";
} elseif ($arr['role'] == 'member') {
    include "member_header.php";
}
// $sql2="select * from news_table 
// INNER JOIN location ON news_table.n_location_id=location.loc_id
// INNER JOIN category ON news_table.n_category_id=category.cat_id
// where news_table.n_category_id='$cid' and news_table.n_location_id='$lid'and is_delete=0 and is_publish=1";
$sql2 = "SELECT *
FROM news_table
INNER JOIN category ON news_table.n_category_id = category.cat_id
INNER JOIN location ON news_table.n_location_id = location.loc_id
INNER JOIN user_details ON news_table.reporter_id = user_details.uid
WHERE news_table.is_delete = 0
AND category.is_delete = 0
AND location.is_delete = 0
AND news_table.is_publish = 1
AND news_table.n_category_id = '$cid'
AND news_table.n_location_id = '$lid'";
$result2 = mysqli_query($conn, $sql2);

?>

<h1 class="text-center text-success mb-4">
    <i class="fa fa-newspaper-o"></i> Published News
</h1>

<h5 class="text-center text-primary mb-3">
    <?php if (isset($_GET['msg'])) echo $_GET['msg']; ?>
</h5>

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
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($result2 as $row) { ?>

                        <?php
                        if ($row['is_publish'] == 1) {
                            $status = '<span class="badge badge-success">Published</span>';
                        } else {
                            $status = '<span class="badge badge-warning text-dark">Unpublished</span>';
                        }
                        ?>

                        <tr>

                            <td class="align-middle font-weight-bold">
                                <?php echo $row['heading']; ?>
                            </td>

                            <td class="text-center align-middle">
                                <img src="<?php echo $row['news_image']; ?>"
                                    class="img-thumbnail rounded"
                                    width="100">
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

                                <button class="btn btn-info btn-sm"
                                    data-toggle="modal"
                                    data-target="#description<?php echo $row['nid']; ?>">
                                    <i class="fa fa-eye"></i> View
                                </button>

                            </td>

                            <td class="text-center align-middle">
                                <?php echo date("d M Y", strtotime($row['posted_date'])); ?>
                            </td>

                            <td class="text-center align-middle">
                                <?php echo $status; ?>
                            </td>

                            <td class="text-center align-middle">

                                <a href="db.php?unpublish=<?php echo $row['nid']; ?>"
                                    class="btn btn-secondary btn-sm mb-1">
                                    <i class="fa fa-times"></i> Unpublish
                                </a>

                                <a href="db.php?delnews=<?php echo $row['nid']; ?>"
                                    class="btn btn-danger btn-sm mb-1"
                                    onclick="return confirm('Are you sure you want to delete this news?')">
                                    <i class="fa fa-trash"></i> Delete
                                </a>

                            </td>

                        </tr>

                        <!-- Description Modal -->
                        <div class="modal fade"
                            id="description<?php echo $row['nid']; ?>"
                            tabindex="-1">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <div class="modal-header bg-primary text-white">

                                        <h5 class="modal-title">
                                            <?php echo $row['heading']; ?>
                                        </h5>

                                        <button type="button"
                                            class="close text-white"
                                            data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>

                                    </div>

                                    <div class="modal-body">

                                        <?php echo nl2br($row['description']); ?>

                                    </div>

                                    <div class="modal-footer">

                                        <button type="button"
                                            class="btn btn-secondary"
                                            data-dismiss="modal">
                                            Close
                                        </button>

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


<?php
include "footer.php";
?>