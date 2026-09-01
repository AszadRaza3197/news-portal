<?php
include "admin_header.php";

$uid = $_SESSION['uid'];

$sql = "SELECT * FROM user_details WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_array($result);

$sql2 = "SELECT uid,name,email
         FROM user_details
         WHERE role='member'
         AND is_verified=0
         AND is_deleted=0";

$result2 = mysqli_query($conn, $sql2);
?>

<div class="container mt-4">

    <div class="card shadow border-warning">

        <div class="card-header bg-warning">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="mb-0 text-dark">
                    <i class="fa fa-user-times"></i>
                    Non Verified Members
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
                            <th>Member Name</th>
                            <th>Email</th>
                            <th width="25%">Action</th>
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
                                    <i class="fa fa-user text-warning"></i>
                                    <?php echo $row['name']; ?>
                                </td>

                                <td>
                                    <?php echo $row['email']; ?>
                                </td>

                                <td class="text-center">

                                    <a href="db.php?aprmember=<?php echo $row['uid']; ?>"
                                        class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Approve
                                    </a>

                                    <a href="db.php?delmember=<?php echo $row['uid']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this member?')">
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
                                <td colspan="4" class="text-center text-danger font-weight-bold">
                                    No Non Verified Members Found
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