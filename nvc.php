<?php
include "admin_header.php";

$uid = $_SESSION['uid'];

$sql = "SELECT * FROM user_details WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_array($result);

$sql2 = "SELECT comment.*, user_details.name, news_table.heading
         FROM comment
         LEFT JOIN user_details ON comment.user_id = user_details.uid
         LEFT JOIN news_table ON comment.news_id = news_table.nid
         WHERE user_details.role='member'
         AND comment.is_verified=0
         AND comment.is_delete=0";

$result2 = mysqli_query($conn, $sql2);
?>

<div class="container mt-4">

    <div class="card shadow border-warning">

        <div class="card-header bg-warning">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="mb-0 text-dark">
                    <i class="fa fa-commenting"></i>
                    Non Verified Comments
                </h3>

                <span class="badge badge-dark p-2">
                    Total :
                    <?php echo mysqli_num_rows($result2); ?>
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
                            <th width="8%">#</th>
                            <th>Comment</th>
                            <th>User</th>
                            <th>News</th>
                            <th width="22%">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $i = 1;

                        foreach ($result2 as $row) {
                        ?>

                            <tr>

                                <td class="text-center">
                                    <?php echo $i++; ?>
                                </td>

                                <td>
                                    <?php echo $row['comments']; ?>
                                </td>

                                <td>
                                    <i class="fa fa-user text-warning"></i>
                                    <?php echo $row['name']; ?>
                                </td>

                                <td>
                                    <?php echo $row['heading']; ?>
                                </td>

                                <td class="text-center">

                                    <a href="db.php?apprcmnt=<?php echo $row['com_id']; ?>"
                                        class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Approve
                                    </a>

                                    <a href="db.php?delcmnt=<?php echo $row['com_id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this comment?')">
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </a>

                                </td>

                            </tr>

                        <?php
                        }

                        if (mysqli_num_rows($result2) == 0) {
                        ?>

                            <tr>
                                <td colspan="5" class="text-center text-danger font-weight-bold">
                                    No Non Verified Comments Found
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