<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['uid']) || empty($_SESSION['uid'])) {
    header("Location: signin.php");
    exit;
}

$uid = $_SESSION['uid'];

$sql = "SELECT
            c.com_id,
            n.nid,
            n.heading,
            c.comments,
            c.date
        FROM `comment` c
        INNER JOIN news_table n
            ON c.news_id = n.nid
        WHERE c.user_id = '$uid'
        ORDER BY c.com_id DESC";

$result = mysqli_query($conn, $sql);

?>

<?php include "member_header.php"; ?>


<div class="container mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="font-weight-bold">
            <i class="fas fa-comment text-primary mr-2"></i>
            My Comments
        </h4>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0">

                    <thead class="thead-dark">

                        <tr>

                            <th width="80">S.No</th>

                            <th>News</th>

                            <th>Comment</th>

                            <th>Comment Date</th>

                            <th width="120">Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php

                        $i = 1;

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {

                        ?>

                                <tr>

                                    <td>
                                        <?php echo $i++; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['heading']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['comments']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['date']; ?>
                                    </td>

                                    <td>

                                        <a href="db.php?delete_comment=<?php echo $row['com_id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this comment?');">

                                            <i class="fas fa-trash mr-1"></i>
                                            Delete

                                        </a>

                                    </td>

                                </tr>

                        <?php

                            }

                        } else {

                        ?>

                            <tr>

                                <td colspan="5" class="text-center text-muted py-4">

                                    No comments found.

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


<?php include "footer.php"; ?>