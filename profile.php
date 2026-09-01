<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['uid']) || empty($_SESSION['uid'])) {
    header("Location: signin.php");
    exit;
}

$uid = $_SESSION['uid'];
$role = $_SESSION['role'];


$sql = "SELECT * FROM user_details
INNER JOIN category ON user_details.cat_id=category.cat_id
INNER JOIN location ON user_details.loc_id=location.loc_id
WHERE uid='$uid'";

$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_array($result);

if ($role == 'admin') {
    include "admin_header.php";
} elseif ($role == 'editor') {
    include "editor_header.php";
} elseif ($role == 'reporter') {
    include "reporter_header.php";
} elseif ($role == 'member') {
    include "member_header.php";
}
?>

<p class="text-danger text-center">
    <?php
    if (isset($msg)) {
        echo $msg;
    }
    ?>
</p>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-center">
                    <h3 class="mb-0 text-dark"><i class="fa fa-user-circle"></i> My Profile</h3>
                </div>
                <div class="card-body text-center">
                    <img src="<?php echo $arr['photo']; ?>" class="rounded-circle img-thumbnail mb-3" width="170" height="170" alt="Profile">
                    <h3 class="font-weight-bold text-dark mb-1"><?php echo $arr['name']; ?></h3>
                    <?php
                    if ($role == "admin") {
                        echo '<span class="badge badge-danger p-2">ADMIN</span>';
                    } elseif ($role == "editor") {
                        echo '<span class="badge badge-success p-2">EDITOR</span>';
                    } elseif ($role == "reporter") {
                        echo '<span class="badge badge-primary p-2">REPORTER</span>';
                    } else {
                        echo '<span class="badge badge-secondary p-2">MEMBER</span>';
                    }
                    ?>
                    <hr>
                    <ul class="list-group text-left mb-4">
                        <li class="list-group-item">
                            <i class="fa fa-id-card text-primary"></i>
                            <strong> User ID :</strong>
                            <span class="float-right"><?php echo $arr['uid']; ?></span>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-phone text-success"></i>
                            <strong> Mobile :</strong>
                            <span class="float-right"><?php echo $arr['mobile']; ?></span>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-envelope text-danger"></i>
                            <strong> Email :</strong>
                            <span class="float-right"><?php echo $arr['email']; ?></span>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-list text-warning"></i>
                            <strong> Category :</strong>
                            <span class="float-right"><?php echo $arr['category']; ?></span>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-map-marker text-info"></i>
                            <strong> Location :</strong>
                            <span class="float-right"><?php echo $arr['location']; ?></span>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-primary btn-block mb-2"
                        data-toggle="modal"
                        data-target="#editProfileModal">
                        <i class="fa fa-edit"></i> Update Profile
                    </a>
                    <a href="#" class="btn btn-danger btn-block"
                        data-toggle="modal"
                        data-target="#changePasswordModal">
                        <i class="fa fa-lock"></i> Change Password
                    </a>
                </div>
                <div class="card-footer text-center bg-light">
                    <small class="text-muted">Welcome, <?php echo $arr['name']; ?></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- edit profile model -->
<div class="modal fade" id="editProfileModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-warning">
                <h5>Edit Profile</h5>

                <button class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <form action="db.php" method="post" enctype="multipart/form-data">

                <div class="modal-body">

                    <input type="hidden" name="uid" value="<?php echo $arr['uid']; ?>">

                    <!-- Current Photo -->
                    <div class="text-center mb-3">
                        <img src="<?php echo $arr['photo']; ?>"
                            class="rounded-circle img-thumbnail"
                            width="120"
                            height="120">
                    </div>

                    <label>Change Profile Photo</label>
                    <input type="file" name="photo" class="form-control mb-3">

                    <label>Name</label>
                    <input type="text"
                        name="name"
                        class="form-control mb-3"
                        value="<?php echo $arr['name']; ?>">

                    <label>Mobile</label>
                    <input type="text"
                        name="mobile"
                        class="form-control mb-3"
                        value="<?php echo $arr['mobile']; ?>">

                    <label>Email</label>
                    <input type="email"
                        name="email"
                        class="form-control mb-3"
                        value="<?php echo $arr['email']; ?>">



                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>

                    <input
                        type="submit"
                        name="updateprofile"
                        value="Update"
                        class="btn btn-warning">

                </div>

            </form>

        </div>
    </div>
</div>

<!-- change password model -->
<div class="modal fade" id="changePasswordModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">

                <h5>Change Password</h5>

                <button class="close text-white"
                    data-dismiss="modal">

                    &times;

                </button>

            </div>

            <form action="db.php" method="post">

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="uid"
                        value="<?php echo $arr['uid']; ?>">

                    <label>Current Password</label>

                    <input
                        type="password"
                        name="oldpassword"
                        class="form-control mb-3">

                    <label>New Password</label>

                    <input
                        type="password"
                        name="newpassword"
                        class="form-control mb-3">

                    <label>Confirm Password</label>

                    <input
                        type="password"
                        name="confirmpassword"
                        class="form-control">

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-secondary"
                        data-dismiss="modal">

                        Close

                    </button>

                    <input
                        type="submit"
                        name="changepassword"
                        value="Change Password"
                        class="btn btn-danger">

                </div>

            </form>

        </div>
    </div>
</div>

<?php
include "footer.php";
?>