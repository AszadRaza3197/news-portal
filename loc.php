<?php
include "admin_header.php";

$uid = $_SESSION['uid'];

$sql = "SELECT * FROM user_details WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_array($result);

$sql2 = "SELECT * FROM location";
$result2 = mysqli_query($conn, $sql2);
?>

<div class="container mt-4">

    <div class="card shadow border-warning">

        <div class="card-header bg-warning">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="mb-0 text-dark">
                    <i class="fa fa-map-marker"></i>
                    Manage Locations
                </h3>

                <button class="btn btn-dark"
                    data-toggle="modal"
                    data-target="#addlocation">
                    <i class="fa fa-plus"></i>
                    Add Location
                </button>

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
                            <th width="10%">#</th>
                            <th>Location Name</th>
                            <th width="18%">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $i = 1;

                        foreach ($result2 as $row) {
                        ?>

                            <!-- <tr> -->
                            <tr <?php if ($row['is_delete'] == 1) { ?> class="table-danger" <?php } ?>>

                                <td class="text-center">
                                    <?php echo $i++; ?>
                                </td>

                                <td>
                                    <i class="fa fa-map-marker text-danger"></i>
                                    <?php echo $row['location']; ?>
                                </td>

                                <!-- <td class="text-center">

                                    <a href="db.php?delloc=<?php echo $row['loc_id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this location?')">
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </a>

                                </td> -->

                                <td class="text-center">

                                    <?php
                                    if ($row['is_delete'] == 0) {
                                    ?>

                                        <a href="db.php?delloc=<?php echo $row['loc_id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this location?')">
                                            <i class="fa fa-trash"></i>
                                            Delete
                                        </a>

                                    <?php
                                    } else {
                                    ?>

                                        <a href="db.php?restoreloc=<?php echo $row['loc_id']; ?>"
                                            class="btn btn-success btn-sm">
                                            <i class="fa fa-undo"></i>
                                            Recover
                                        </a>

                                    <?php
                                    }
                                    ?>

                                </td>

                            </tr>

                        <?php
                        }

                        if (mysqli_num_rows($result2) == 0) {
                        ?>

                            <tr>
                                <td colspan="3" class="text-center text-danger font-weight-bold">
                                    No Locations Found
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

<!-- Add Location Modal -->

<div class="modal fade" id="addlocation">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header bg-warning">

                <h5 class="modal-title text-dark">
                    <i class="fa fa-plus-circle"></i>
                    Add New Location
                </h5>

                <button type="button"
                    class="close"
                    data-dismiss="modal">
                    &times;
                </button>

            </div>

            <form action="db.php" method="POST">

                <div class="modal-body">

                    <div class="form-group">

                        <label>
                            <strong>Location Name</strong>
                        </label>

                        <input type="text"
                            name="location"
                            class="form-control"
                            placeholder="Enter Location Name"
                            required>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                        Close
                    </button>

                    <button type="submit"
                        name="aloc"
                        class="btn btn-warning">
                        <i class="fa fa-save"></i>
                        Save
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php
include "footer.php";
?>