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
            b.bid,
            n.nid,
            n.heading,
            b.bookmark_date
        FROM `bookmark` b
        INNER JOIN news_table n
            ON b.news_id = n.nid
        WHERE b.user_id = '$uid'
        ORDER BY b.bid DESC";

$result = mysqli_query($conn, $sql);

?>

<?php include "member_header.php"; ?>


<div class="container mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="font-weight-bold">
            <i class="fas fa-bookmark text-primary mr-2"></i>
            My Bookmarks
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

                            <th>Bookmark Date</th>

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
                                        <?php echo $row['bookmark_date']; ?>
                                    </td>

                                    <td>

                                        <a href="db.php?delete_bookmark=<?php echo $row['bid']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to remove this bookmark?');">

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

                                <td colspan="4" class="text-center text-muted py-4">

                                    No bookmarks found.

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