<?php
include "admin_header.php";

$uid = $_SESSION['uid'];
$eid = $_SESSION['uid'];
$lid = $_SESSION['lid'];
$cid = $_SESSION['cid'];

$sql = "SELECT * FROM user_details WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_array($result);

$sql2 = "SELECT news_table.*,category.category,location.location
         FROM news_table
         INNER JOIN category
            ON news_table.n_category_id=category.cat_id
         INNER JOIN location
            ON news_table.n_location_id=location.loc_id
         WHERE news_table.is_delete=0
         AND news_table.is_publish=0";

$result2 = mysqli_query($conn, $sql2);
?>

<div class="container-fluid mt-4">

    <div class="card shadow border-warning">

        <div class="card-header bg-warning">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="mb-0 text-dark">
                    <i class="fa fa-newspaper-o"></i>
                    Unpublished News
                </h3>

                <span class="badge badge-dark p-2">
                    Total : <?php echo mysqli_num_rows($result2); ?>
                </span>

            </div>

        </div>

        <div class="card-body">

            <?php if (isset($_GET['msg'])) { ?>
                <div class="alert alert-success">
                    <?php echo $_GET['msg']; ?>
                </div>
            <?php } ?>

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-dark">

                        <tr class="text-center">
                            <th width="5%">#</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th width="25%">Description</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th width="20%">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $i = 1;

                        foreach ($result2 as $row) {

                            $status = "<span class='badge badge-secondary'>Not Published</span>";
                        ?>

                            <tr>

                                <td class="text-center">
                                    <?php echo $i++; ?>
                                </td>

                                <td>
                                    <strong><?php echo $row['heading']; ?></strong>
                                </td>

                                <td class="text-center">
                                    <img src="<?php echo $row['news_image']; ?>"
                                        class="img-thumbnail"
                                        width="80"
                                        height="60">
                                </td>

                                <td>
                                    <span class="badge badge-warning">
                                        <?php echo $row['category']; ?>
                                    </span>
                                </td>

                                <td>
                                    <i class="fa fa-map-marker text-danger"></i>
                                    <?php echo $row['location']; ?>
                                </td>

                                <td>

                                    <?php

                                    $desc = strip_tags($row['description']);

                                    if (strlen($desc) > 80) {
                                        echo substr($desc, 0, 80) . ".....";
                                    } else {
                                        echo $desc;
                                    }

                                    ?>

                                </td>

                                <td>
                                    <?php echo date("d M Y", strtotime($row['posted_date'])); ?>
                                </td>

                                <td class="text-center">
                                    <?php echo $status; ?>
                                </td>

                                <td class="text-center">

                                    <a href="db.php?vnid=<?php echo $row['nid']; ?>"
                                        class="btn btn-info btn-sm"
                                        title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <!-- <a href="db.php?publish=<?php echo $row['nid']; ?>"
                                        class="btn btn-success btn-sm"
                                        title="Publish">
                                        <i class="fa fa-upload"></i>
                                    </a> -->

                                    <a href="db.php?delnews=<?php echo $row['nid']; ?>"
                                        class="btn btn-danger btn-sm"
                                        title="Delete"
                                        onclick="return confirm('Delete this news?')">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </td>

                            </tr>

                        <?php
                        }

                        if (mysqli_num_rows($result2) == 0) {
                        ?>

                            <tr>
                                <td colspan="9" class="text-center text-danger font-weight-bold">
                                    No Unpublished News Found
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