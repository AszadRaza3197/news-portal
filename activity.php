<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($conn)) {
    $conn = mysqli_connect("localhost", "root", "", "news");
}
include "admin_header.php";

$uid = intval($_SESSION['uid'] ?? 0);

$sql = "SELECT * FROM user_details WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
$arr = $result ? mysqli_fetch_array($result) : null;

$sql2 = "SELECT * FROM activity_log ORDER BY time DESC";
$result2 = mysqli_query($conn, $sql2);
?>

<div class="container mt-4">

    <div class="card shadow border-warning">

        <div class="card-header bg-warning">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="mb-0 text-dark">
                    <i class="fa fa-history"></i>
                    Activity Log
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
                            <th>User ID</th>
                            <th>Role</th>
                            <th>Action</th>
                            <th>Affected</th>
                            <th>Date & Time</th>

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

                                <td class="text-center">
                                    <span class="badge badge-primary">
                                        <?php echo $row['uid']; ?>
                                    </span>
                                </td>

                                <td>

                                    <?php
                                    if ($row['role'] == "admin") {
                                        echo '<span class="badge badge-danger">Admin</span>';
                                    } elseif ($row['role'] == "editor") {
                                        echo '<span class="badge badge-warning">Editor</span>';
                                    } elseif ($row['role'] == "reporter") {
                                        echo '<span class="badge badge-info">Reporter</span>';
                                    } else {
                                        echo '<span class="badge badge-success">Member</span>';
                                    }
                                    ?>

                                </td>

                                <td>
                                    <i class="fa fa-cogs text-primary"></i>
                                    <?php echo ucfirst($row['action']); ?>
                                </td>

                                <td>
                                    <?php echo $row['affected']; ?>
                                </td>

                                <td>
                                    <i class="fa fa-clock-o text-secondary"></i>
                                    <?php echo date("d M Y h:i A", strtotime($row['time'])); ?>
                                </td>

                            </tr>

                        <?php
                        }

                        if (mysqli_num_rows($result2) == 0) {
                        ?>

                            <tr>
                                <td colspan="6" class="text-center text-danger font-weight-bold">
                                    No Activity Found
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