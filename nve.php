<?php
include "admin_header.php";

$uid = $_SESSION['uid'];
$role = $_SESSION['role'];

$sql = "SELECT * FROM user_details WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_array($result);



$sql2 = "SELECT u.uid,u.name,u.email,u.cat_id,u.loc_id,
         c.category AS category_name,
         l.location AS location_name
         FROM user_details u
         LEFT JOIN category c ON u.cat_id=c.cat_id
         LEFT JOIN location l ON u.loc_id=l.loc_id
         WHERE u.role='editor'
         AND u.is_verified=0
         AND u.is_deleted=0";

$result2 = mysqli_query($conn, $sql2);
?>

<div class="container mt-4">

    <div class="card shadow border-warning">

        <div class="card-header bg-warning">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="mb-0 text-dark">
                    <i class="fa fa-user-times"></i>
                    Non Verified Editors
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
                            <th>Editor Name</th>
                            <th>Email</th>
                            <th>Category</th>
                            <th>Location</th>
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

                                <td>
                                    <span class="badge badge-warning">
                                        <?php echo $row['category_name']; ?>
                                    </span>
                                </td>

                                <td>
                                    <i class="fa fa-map-marker text-danger"></i>
                                    <?php echo $row['location_name']; ?>
                                </td>

                                <td class="text-center">

                                    <a href="db.php?apreditor=<?php echo $row['uid']; ?>"
                                        class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Approve
                                    </a>

                                    <a href="db.php?deleditor=<?php echo $row['uid']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this editor?')">
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </a>

                                </td>

                            </tr>

                        <?php
                        }
                        ?>

                        <?php
                        if (mysqli_num_rows($result2) == 0) {
                        ?>

                            <tr>
                                <td colspan="5" class="text-center text-danger font-weight-bold">
                                    No Non Verified Editors Found
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