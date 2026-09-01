<?php
$conn = mysqli_connect("localhost", "root", "", "news");
// Auto-publish scheduled news whose scheduled time has arrived
mysqli_query($conn, "UPDATE news_table SET is_publish = 1, is_scheduled = 0 WHERE is_scheduled = 1 AND scheduled_publish_at IS NOT NULL AND scheduled_publish_at <= NOW() AND is_delete = 0");

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($data))    //its compulsory to do this otherwise it will keep warning you untill the page getting called
{
    if (isset($data['action']) && $data['action'] == "getcategory") {
        $sql = "select * from category where is_delete=0";
        $result = mysqli_query($conn, $sql);
        echo "<option value='1' selected>Select Category</option>";
        foreach ($result as $row) {
            $cid = $row['cat_id'];
            $cname = htmlspecialchars($row['category']);
            echo "<option value='$cid'>$cname</option>";
        }
    } elseif (isset($data['action']) && $data['action'] == "getlocation") {
        $sql = "select * from location where is_delete=0";
        $result = mysqli_query($conn, $sql);
        echo "<option value='1' selected>Select Location</option>";
        foreach ($result as $row) {
            $lid = $row['loc_id'];
            $lname = htmlspecialchars($row['location']);
            echo "<option value='$lid'>$lname</option>";
        }
    }
} elseif (isset($_POST['signup']))    //signup code start here
{
    $n = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $m = mysqli_real_escape_string($conn, $_POST['mobile'] ?? '');
    $e = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $r = mysqli_real_escape_string($conn, $_POST['role'] ?? '');
    if ($r == 'editor' || $r == 'reporter') {
        $cat = intval($_POST['category'] ?? 1);
        $loc = intval($_POST['location'] ?? 1);
    } else {
        $cat = 1;
        $loc = 1;
    }

    $psw = $_POST['password'] ?? '';
    if (empty($n) || empty($m) || empty($e) || empty($r) || empty($psw)) {
        header("Location:signup.php?msg=all fields are necessary");
        exit;
    } else {
        //emailcheck
        $check = "select * from user_details where email='$e'";
        $result = mysqli_query($conn, $check);
        $row = mysqli_num_rows($result);

        if ($row > 0) {
            header("Location:signup.php?msg=email already exists!");
            exit;
        } else {
            //password hashing
            $hash = password_hash($psw, PASSWORD_DEFAULT);

            //inserting the data
            $sql1 = "insert into user_details (name,mobile,email,password,role,cat_id,loc_id) values('$n','$m','$e','$hash','$r','$cat','$loc')";
            $run = mysqli_query($conn, $sql1);
            if ($run) {
                $uid = mysqli_insert_id($conn);
                $sql_ins = "insert into activity_log(uid,role,action) values('$uid','$r','signed up')";
                mysqli_query($conn, $sql_ins);

                header("Location:signup.php?msg=You have signedup Succesfully!!");
                exit;
            } else {
                header("Location:signup.php?msg=registration failed!!");
                exit;
            }
        }
    }
} //signup code end

//login code start
elseif (isset($_POST['login'])) {
    $e = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $psw = $_POST['password'] ?? '';

    if (!empty($e) && !empty($psw)) {
        $sql = "select * from user_details where email='$e' and is_deleted=0";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $arr = mysqli_fetch_array($result);

            // Verify hashed password or fallback to legacy plaintext
            $isValidPassword = password_verify($psw, $arr['password']) || ($psw === $arr['password']);

            if ($isValidPassword) {
                // If legacy plaintext password matched, re-hash it to modern hash
                if ($psw === $arr['password']) {
                    $new_hash = password_hash($psw, PASSWORD_DEFAULT);
                    $new_hash_escaped = mysqli_real_escape_string($conn, $new_hash);
                    mysqli_query($conn, "update user_details set password='$new_hash_escaped' where uid='" . $arr['uid'] . "'");
                }

                if ($arr['is_verified'] == 1) {
                    $_SESSION['uid'] = $arr['uid'];
                    $_SESSION['role'] = $arr['role'];
                    $_SESSION['lid'] = $arr['loc_id'];
                    $_SESSION['cid'] = $arr['cat_id'];

                    $uid = $_SESSION['uid'];
                    $role = $_SESSION['role'];

                    $sql_ins = "insert into activity_log(uid,role,action) values('$uid','$role','logged in')";
                    mysqli_query($conn, $sql_ins);

                    header("Location: dashboard.php");
                    exit;
                } else {
                    header("Location:signin.php?msg=You are not verified yet. Please wait for admin approval.");
                    exit;
                }
            } else {
                header("Location:signin.php?msg=Your Password is Wrong, Please Check it !!");
                exit;
            }
        } else {
            header("Location:signin.php?msg=No user found with this email !!");
            exit;
        }
    } else {
        header("Location:signin.php?msg=All fields are mandatory");
        exit;
    }
}
// logout
elseif (isset($_GET['logout'])) {
    if (isset($_SESSION['uid']) && isset($_SESSION['role'])) {
        $uid = intval($_SESSION['uid']);
        $role = mysqli_real_escape_string($conn, $_SESSION['role']);
        $sql_ins = "insert into activity_log(uid,role,action) values('$uid','$role','logged out')";
        mysqli_query($conn, $sql_ins);
    }
    session_unset();
    session_destroy();
    header("Location: signin.php");
    exit;
}

//profile pic code start
elseif (isset($_POST['pic'])) {
    $uid = $_SESSION['uid'];
    $filename = $_FILES['img']['name'];
    $x = $_FILES['img']['tmp_name'];
    $sz = $_FILES['img']['size'];    //iimprotant
    $type = $_FILES['img']['type'];  //improtant
    $y = "profilepics/" . $filename;
    if ($type == 'image/jpeg' || $type == 'image/gif' || $type == 'image/png') {
        $imageinfo = getimagesize($x);  //important
        $w = $imageinfo[0];
        $h = $imageinfo[1];
        if ($w > 1000 && $h > 1000) {
            echo "the uploaded image height should be less than 1000px and width should be less than 1000px";
        } else {
            if ($sz < 100000) {

                move_uploaded_file($x, $y);
                $sql = "update user_details set photo='$y' where uid='$uid'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    require "profile.php";
                } else {
                    echo "upload failed";
                }
            } else {
                echo "the profile pic size is more than 100kb upload a small image";
            }
        }
    } else {
        echo "image format should be jpg,jpeg or gif";
    }
}
//profile pic code end

elseif (isset($_GET['profile']))   //thiss is  for header function to work when clic profile or else it will show error
{
    if (!isset($_SESSION['uid']) || empty($_SESSION['uid'])) {
        header("Location: signin.php");
        exit;
    }
    require "profile.php";
} elseif (isset($_GET['nvm']))   //thiss is  for header function to work when clic profile or else it will show error
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    require "nvm.php";
} elseif (isset($_GET['aprmember']))   //approve buton to approve member
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $uid = $_SESSION['uid'];
        $role = $_SESSION['role'];
        $mid = intval($_GET['aprmember']);
        $sql = "update user_details set is_verified=1 where uid='$mid'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','approved a member','$mid')";
            $result2 = mysqli_query($conn, $sql_ins);
        }
    }
    require "nvm.php";
} elseif (isset($_GET['delmember']))   //delete buton to delete member
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $uid = $_SESSION['uid'];
        $role = $_SESSION['role'];
        $mid = intval($_GET['delmember']);
        $sql = "update user_details set is_deleted=1 where uid='$mid'";
        $result = mysqli_query($conn, $sql);
    }
    require "nvm.php";
} elseif (isset($_GET['vm']))   //thiss is  for header function to work when clic profile or else it will show error
{
    $uid = $_SESSION['uid'] ?? 0;
    $role = $_SESSION['role'] ?? '';
    require "vm.php";
} elseif (isset($_GET['blockmember']))   //disaprove buton to disapprove person from verified members page
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $uid = $_SESSION['uid'];
        $role = $_SESSION['role'];
        $mid = intval($_GET['blockmember']);
        $sql = "update user_details set is_verified=0 where uid='$mid'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','disapproved a member','$mid')";
            $result2 = mysqli_query($conn, $sql_ins);
        }
    }
    require "vm.php";
} elseif (isset($_GET['nvr']))   //this is for non verified reporters page
{
    $uid = $_SESSION['uid'] ?? 0;
    $role = $_SESSION['role'] ?? '';
    require "nvr.php";
} elseif (isset($_GET['aprreporter']))   //approve buton to approve reporter
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $uid = $_SESSION['uid'];
        $role = $_SESSION['role'];
        $mid = intval($_GET['aprreporter']);
        $sql = "update user_details set is_verified=1 where uid='$mid'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','approved a reporter','$mid')";
            $result2 = mysqli_query($conn, $sql_ins);
        }
    }
    require "nvr.php";
} elseif (isset($_GET['delreporter']))   //delete buton to delete reporter from nvr
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $uid = $_SESSION['uid'];
        $role = $_SESSION['role'];
        $mid = intval($_GET['delreporter']);
        $sql = "update user_details set is_deleted=1 where uid='$mid'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','deleted non verified reporter','$mid')";
            $result2 = mysqli_query($conn, $sql_ins);
        }
    }
    require "nvr.php";
} elseif (isset($_GET['vr']))   //this is for verified reporters page from menu nav bar
{
    $uid = $_SESSION['uid'] ?? 0;
    $role = $_SESSION['role'] ?? '';
    require "vr.php";
} elseif (isset($_GET['disreporter']))   //disaapprove buton to disapprove reporter from verified reporter page
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $uid = $_SESSION['uid'];
        $role = $_SESSION['role'];
        $mid = intval($_GET['disreporter']);
        $sql = "update user_details set is_verified=0 where uid='$mid'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','disapproved a reporter','$mid')";
            $result2 = mysqli_query($conn, $sql_ins);
        }
    }
    require "vr.php";
} elseif (isset($_GET['delreporter2']))   //delete buton to delete reporter from verified reporter
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $uid = $_SESSION['uid'];
        $role = $_SESSION['role'];
        $mid = intval($_GET['delreporter2']);
        $sql = "update user_details set is_deleted=1 where uid='$mid'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','deleted verified reporter','$mid')";
            $result2 = mysqli_query($conn, $sql_ins);
        }
    }
    require "vr.php";
} elseif (isset($_GET['nve']))   //this is for non verified editors page from menu nav bar
{
    $uid = $_SESSION['uid'] ?? 0;
    $role = $_SESSION['role'] ?? '';
    require "nve.php";
} elseif (isset($_GET['apreditor']))   //approve buton to approve editor for nonverified editor page
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $uid = $_SESSION['uid'];
        $role = $_SESSION['role'];
        $mid = intval($_GET['apreditor']);
        $sql = "update user_details set is_verified=1 where uid='$mid'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','approved an editor','$mid')";
            $result2 = mysqli_query($conn, $sql_ins);
        }
    }
    require "nve.php";
} elseif (isset($_GET['deleditor']))   //delete buton to delete editor from non verified editor
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $uid = $_SESSION['uid'];
        $role = $_SESSION['role'];
        $mid = intval($_GET['deleditor']);
        $sql = "update user_details set is_deleted=1 where uid='$mid'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','deleted a verified editor','$mid')";
            $result2 = mysqli_query($conn, $sql_ins);
        }
    }
    require "nve.php";
} elseif (isset($_GET['ve']))   //this is for verified editors page from menu nav bar
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    require "ve.php";
} elseif (isset($_GET['diseditor']))   //disapprove buton to disapprove editor for verified editor page
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $mid = $_GET['diseditor'];
    $sql = "update user_details set is_verified=0 where uid='$mid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','disapproved an editor','$mid')";
        $result2 = mysqli_query($conn, $sql_ins);
        require "ve.php";
    }
} elseif (isset($_GET['deleditor2']))   //delete buton to delete editor from non verified editor
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $mid = $_GET['deleditor2'];
    $sql = "update user_details set is_deleted=1 where uid='$mid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','deleted nonverified editor','$mid')";
        $result2 = mysqli_query($conn, $sql_ins);
        require "ve.php";
    }
} elseif (isset($_GET['vc']))   //thiss is  for comments header function to work when clic profile or else it will show error
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    require "vc.php";
} elseif (isset($_GET['blockcmnt']))   //thiss is  for admin to disverify comment
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $comid = $_GET['blockcmnt'];
    $sql = "update comment set is_verified=0 where com_id=$comid";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','disverified a comment ',' comment id is $comid')";
        $result2 = mysqli_query($conn, $sql_ins);
        $msg = "comment delted successfully";
        require "vc.php";
    }
} elseif (isset($_GET['delcmnt']))   //thiss is  for admin to disverify comment
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $comid = $_GET['delcmnt'];
    $sql = "update comment set is_delete=0 where com_id=$comid";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','deleted a comment ',' comment id is $comid')";
        $result2 = mysqli_query($conn, $sql_ins);
        $msg = "comment delted successfully";
        require "vc.php";
    }
} elseif (isset($_GET['nvc']))   //thiss is  for nonverified comments header function to work when clic profile or else it will show error
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    require "nvc.php";
} elseif (isset($_GET['apprcmnt']))   //thiss is  for admin to approve comment
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $comid = $_GET['apprcmnt'];
    $sql = "update comment set is_verified=1 where com_id=$comid";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','approved a comment ',' comment id is $comid')";
        $result2 = mysqli_query($conn, $sql_ins);
        $msg = "comment delted successfully";
        require "nvc.php";
    }
} elseif (isset($_GET['loc']))   //this is for locations page in nav bar
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    require "loc.php";
} elseif (isset($_POST['aloc']))  //this is for adding location
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $loc = $_POST['location'];
    $sql = "select * from location where location='$loc'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($result);
    if ($row > 0)   //checkeing if the entered location already exists in database
    {
        echo "location already exists enter a new one";
    } else {
        $sql = "insert into location(location) values('$loc')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','added a location',' the location is $loc')";
            $result2 = mysqli_query($conn, $sql_ins);
            require "loc.php";
        } else {
            echo "location insertion failed";
        }
    }
}

// elseif (isset($_GET['delloc'])) {
//     $uid = $_SESSION['uid'];
//     $role = $_SESSION['role'];
//     $lid = $_GET['delloc'];
//     $sql = "delete from location where loc_id='$lid'";
//     $result = mysqli_query($conn, $sql);
//     if ($result) {
//         $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','deleted a location',' location id is $lid')";
//         $result2 = mysqli_query($conn, $sql_ins);
//         require "loc.php";
//     } else {
//         echo "location deltion failed";
//     }
// } 

// delete location
elseif (isset($_GET['delloc'])) {

    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $lid = $_GET['delloc'];

    $sql = "UPDATE location SET is_delete='1' WHERE loc_id='$lid'";
    $result = mysqli_query($conn, $sql);

    if ($result) {

        $sql_ins = "INSERT INTO activity_log(uid,role,action,affected)
                    VALUES('$uid','$role','deleted a location','Location ID : $lid')";
        mysqli_query($conn, $sql_ins);

        require "loc.php";
        exit();
    } else {

        echo "Location deletion failed.";
    }
}
// recover location
elseif (isset($_GET['restoreloc'])) {

    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $lid = $_GET['restoreloc'];

    $sql = "UPDATE location SET is_delete='0' WHERE loc_id='$lid'";
    $result = mysqli_query($conn, $sql);

    if ($result) {

        $sql_ins = "INSERT INTO activity_log(uid,role,action,affected)
                    VALUES('$uid','$role','recovered a location','Location ID : $lid')";
        mysqli_query($conn, $sql_ins);

        // header("Location: loc.php?msg=Location Recovered Successfully");
        require "loc.php";
        exit();
    } else {

        echo "Location recovery failed.";
    }
} elseif (isset($_GET['cat']))   //this is for category page in nav bar
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    require "cat.php";
} elseif (isset($_POST['acat']))  //this is for adding category
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $cat = $_POST['category'];
    $sql = "select * from category where category='$cat'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($result);
    if ($row > 0)   //checkeing if the entered category already exists in database
    {

        echo "category already exists enter a new one";
    } else {
        $sql = "insert into category(category) values('$cat')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','added a new category','$cat')";
            $result2 = mysqli_query($conn, $sql_ins);
            require "cat.php";
        } else {
            echo "category insertion failed";
        }
    }
}
// elseif (isset($_GET['delcat'])) {
//     $uid = $_SESSION['uid'];
//     $role = $_SESSION['role'];
//     $cid = $_GET['delcat'];
//     $sql = "delete from category where cat_id='$cid'";
//     $result = mysqli_query($conn, $sql);
//     if ($result) {
//         $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','deketed category','the catid is $cid')";
//         $result2 = mysqli_query($conn, $sql_ins);
//         require "cat.php";
//     } else {
//         echo "category deltion failed";
//     }
// }

// delete category
elseif (isset($_GET['delcat'])) {

    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $cid = $_GET['delcat'];

    $sql = "UPDATE category SET is_delete='1' WHERE cat_id='$cid'";
    $result = mysqli_query($conn, $sql);

    if ($result) {

        $sql_ins = "INSERT INTO activity_log(uid,role,action,affected)
                    VALUES('$uid','$role','deleted a category','Category ID : $cid')";
        mysqli_query($conn, $sql_ins);

        // header("Location: cat.php?msg=Category Deleted Successfully");
        require "cat.php";
        exit();
    } else {

        echo "Category deletion failed.";
    }
}
// recover category
elseif (isset($_GET['restorecat'])) {

    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $cid = $_GET['restorecat'];

    $sql = "UPDATE category SET is_delete='0' WHERE cat_id='$cid'";
    $result = mysqli_query($conn, $sql);

    if ($result) {

        $sql_ins = "INSERT INTO activity_log(uid,role,action,affected)
                    VALUES('$uid','$role','recovered a category','Category ID : $cid')";
        mysqli_query($conn, $sql_ins);

        // header("Location: cat.php?msg=Category Recovered Successfully");
        require "cat.php";
        exit();
    } else {

        echo "Category recovery failed.";
    }
}
//when reporter clicks upload news in navbar this code starts
if (isset($_GET['unews'])) {

    require "unews.php";
}          //end of the upload news page


if (isset($_GET['myn'])) //display news for reporter
{
    require "mynews.php";
}

if (isset($_GET['edit'])) //edit news for reporter
{
    $nid = $_GET['edit'];
    require "editnews.php";
}
//this is updating the edit news
if (isset($_POST['enews'])) {
    $nid = $_POST['nid'];
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $filename = "newspic/" . $_FILES['nimg']['name'];
    if (!empty($_FILES['nimg']['name'])) {
        move_uploaded_file($_FILES['nimg']['tmp_name'], $filename);
        $sql = "UPDATE news_table SET heading='$title', description='$desc',news_image='$filename' where nid='$nid' ";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $uid = $_SESSION['uid'];
            $role = $_SESSION['role'];
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','edited news',' news id:$nid')";
            $result2 = mysqli_query($conn, $sql_ins);
            $msg = "update successful";
            require "mynews.php";
        } else {
            $msg = "update failed";
            require "mynews.php";
        }
    }
    //this else is updation without image being uploaded

    else {
        $sql = "UPDATE news_table SET heading='$title', description='$desc' where nid='$nid' ";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $msg = "update successful";
            require "mynews.php";
        } else {
            $msg = "update failed";
            require "mynews.php";
        }
    }
}
if (isset($_GET['editor']))  //if editor clicks on his profile
{
    if (!isset($_SESSION['uid']) || empty($_SESSION['uid'])) {
        header("Location: signin.php");
        exit;
    }
    $eid = $_SESSION['uid'];
    $lid = isset($_SESSION['lid']) ? $_SESSION['lid'] : 1;
    $cid = isset($_SESSION['cid']) ? $_SESSION['cid'] : 1;
    require "profile.php";
}
if (isset($_GET['upnews'])) //if editor clicks unpublished news in navbar
{
    require "newsnv.php";
}
if (isset($_GET['publish'])) {

    $nid = $_GET['publish'];

    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];

    $sql = "UPDATE news_table 
            SET is_publish = 1,
                editor_id = '$uid'
            WHERE nid = '$nid'";

    $result = mysqli_query($conn, $sql);

    if ($result) {

        $sql_ins = "INSERT INTO activity_log(uid, role, action, affected) 
                    VALUES('$uid', '$role', 'published news', 'newsid: $nid')";

        $result2 = mysqli_query($conn, $sql_ins);

        $msg = "News published successfully";

        require "newsnv.php";
    }
}
if (isset($_GET['pnews'])) //if editor clicks unpublished news in navbar
{
    require "newsv.php";
}
if (isset($_GET['unpublish'])) //if editor click unpublish button on table in frontend
{
    $nid = $_GET['unpublish'];
    $sql = "update news_table set is_publish=0 where nid='$nid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $msg = "news published successfully";
        require "newsv.php";
    }
} elseif (isset($_GET['vnid'])) //if editor clicks to view descriptio button it redirects to a new page
{
    $nid = $_GET['vnid'];
    require "viewnews.php";
} elseif (isset($_GET['envr']))   //this is for non verified reporters page
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    require "envr.php";
} elseif (isset($_GET['eaprreporter']))   //approve buton for editor to approve reporter
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $mid = $_GET['eaprreporter'];
    $sql = "update user_details set is_verified=1 where uid='$mid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','approved a reporter','reporter id :$mid')";
        $result2 = mysqli_query($conn, $sql_ins);
        require "envr.php";
    }
} elseif (isset($_GET['evr']))   //this is for non verified reporters page
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    require "evr.php";
} elseif (isset($_GET['edisaprreporter']))   //disapprove buton for editor to disapprove reporter
{
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $mid = $_GET['edisaprreporter'];
    $sql = "update user_details set is_verified=0 where uid='$mid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','disapproved a reporter',' reporter id :$mid')";
        $result2 = mysqli_query($conn, $sql_ins);
        require "evr.php";
    }
}
if (isset($_GET['adpnews'])) //if admin clicks published news in navbar
{
    require "adnewsv.php";
}
if (isset($_GET['adupnews'])) //if admin clicks unpublished news in navbar
{
    require "adnewsnv.php";
}
if (isset($_GET['singlenews'])) //from index anyone clicks on the latest news
{
    $nid = $_GET['singlenews'];
    $query = "update news_table set views= views+1 where nid='$nid'";
    $qresult = mysqli_query($conn, $query);
    require "single.php";
}

if (isset($_GET['memindex'])) {
    if (isset($_SESSION['uid'])) {
        $mid = $_SESSION['uid'];     //this mid is member id necessary for comment insertions
    }
    require "index.php";
}

if (isset($_GET['singlenews2'])) //from index member clicks on the latest news
{

    $nid = $_GET['singlenews2'];
    $query = "update news_table set views = views+1 where nid='$nid'";
    $qresult = mysqli_query($conn, $query);
    require "single2.php";
}

//comments insertion code start some repairs needs to be done to this code
if (isset($_GET['newsid']) && isset($_GET['mid']) && isset($_POST['comment'])) {
    if (!empty($_GET['mid'])) {
        if (!empty($_POST['comment'])) {
            $nid = $_GET['newsid'];
            $uid    = $_GET['mid'];         //this uid should be member id not reporter id once check
            echo $uid;
            $comment = $_POST['comment'];
            $sql = "insert into comment(news_id,user_id,comments) values('$nid','$uid','$comment') ";
            $result = mysqli_query($conn, $sql);
            //activity log
            $sql_ins = "insert into activity_log(uid,role,action,affected) values('$uid','$role','commented on news','newsid:$nid')";
            $result2 = mysqli_query($conn, $sql_ins);
            require "single2.php";
        } else {
            require "single.php";
        }
    } else {
        $msg = "please log in to comment";
        require "single.php";
    }
}
//comment insertion code end

//trending news click on view more button
if (isset($_GET['readmore'])) {
    $nid = $_GET['readmore'];
    require "single2.php";
}

//comment reply code start
if (isset($_GET['newsid2']) && isset($_GET['mid2']) && isset($_POST['reply'])) {
    if (!empty($_GET['mid2'])) {
        if (!empty($_POST['reply'])) {
            $nid = $_GET['newsid2'];
            $uid    = $_GET['mid2'];         //this uid should be member id not reporter id once check
            $cmid = $_GET['cmid'];

            $reply = $_POST['reply'];
            $sql = "insert into comment(news_id,user_id,comments,replied_on) values('$nid','$uid','$reply',) ";
            $result = mysqli_query($conn, $sql);

            require "single2.php";
        } else {
            require "single.php";
        }
    } else {
        $msg = "please log in to comment";
        require "single.php";
    }
}
// if (isset($_GET['like'])) {
//     $nid = $_GET['like'];
//     $uid = $_SESSION['uid'];
//     $role = $_SESSION['role'];
//     if ($role == 'member') {
//         $sql = "select * from likes where user_id='$uid' and news_id='$nid'";
//         $result = mysqli_query($conn, $sql);
//         $row = mysqli_num_rows($result);
//         if ($row > 0) {
//             $class = "disabled";
//             require "single2.php";
//         } else {
//             $sql = "insert into likes(user_id,news_id) values('$uid','$nid')";
//             $result = mysqli_query($conn, $sql);
//             if ($result) {

//                 require "single2.php";
//             }
//         }
//     } else {
//         $msg = "please signin to like comment on news";
//         require "signin.php";
//     }
// }

if (isset($_GET['like'])) {

    $nid = $_GET['like'];


    /* =========================
       LOGIN CHECK
    ========================= */

    if (!isset($_SESSION['uid'])) {

        $msg = "Please signin to like news.";

        require "signin.php";

        exit;
    }


    $uid = $_SESSION['uid'];

    $role = $_SESSION['role'];


    /* =========================
       MEMBER CHECK
    ========================= */

    if ($role == 'member') {


        /* =========================
           CHECK ALREADY LIKED
        ========================= */

        $sql_check = "SELECT like_id
                      FROM likes
                      WHERE user_id='$uid'
                      AND news_id='$nid'";

        $result_check = mysqli_query($conn, $sql_check);


        if (mysqli_num_rows($result_check) > 0) {

            /*
             * Already liked
             * Dobara insert nahi hoga
             */

            header("Location: single2.php?nid=$nid");

            exit;
        }


        /* =========================
           INSERT LIKE
        ========================= */

        $sql_like = "INSERT INTO likes(user_id, news_id)
                     VALUES('$uid', '$nid')";

        $result_like = mysqli_query($conn, $sql_like);


        if ($result_like) {

            header("Location: single2.php?nid=$nid");

            exit;
        } else {

            echo "Like failed.";
        }
    } else {

        $msg = "Only members can like news.";

        require "signin.php";

        exit;
    }
}
if (isset($_GET['act'])) {
    $uid = $_SESSION['uid'];
    require "activity.php";
}

//messages inbox

if (isset($_GET['message'])) {
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    require "message.php";
}

//bookmark

if (isset($_GET['book'])) {

    if (!isset($_SESSION['uid'])) {

        $msg = "Please login first";
        require "signin.php";
        exit;
    }

    $uid = $_SESSION['uid'];
    $news_id = $_GET['Id'];

    // Check whether already bookmarked
    $check_sql = "SELECT * FROM bookmark 
                  WHERE user_id='$uid' 
                  AND news_id='$news_id'";

    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {

        $msg = "News already bookmarked";
    } else {

        $sql = "INSERT INTO bookmark(user_id, news_id)
                VALUES('$uid', '$news_id')";

        $result = mysqli_query($conn, $sql);

        if ($result) {

            $msg = "News bookmarked successfully";
        } else {

            $msg = "Something went wrong";
        }
    }

    require "single2.php";
}


// update profile
elseif (isset($_POST['updateprofile'])) {

    $uid = $_POST['uid'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];

    if (!empty($_FILES['photo']['name'])) {

        $filename = $_FILES['photo']['name'];
        $tmp = $_FILES['photo']['tmp_name'];
        $size = $_FILES['photo']['size'];
        $type = $_FILES['photo']['type'];

        $path = "profilepics/" . $filename;

        if ($type == "image/jpeg" || $type == "image/jpg" || $type == "image/png" || $type == "image/gif") {

            if ($size <= 1000000) {

                move_uploaded_file($tmp, $path);

                $sql = "UPDATE user_details SET
                        name='$name',
                        mobile='$mobile',
                        email='$email',
                        photo='$path'
                        WHERE uid='$uid'";
            } else {

                $msg = "Image size should be less than 1MB";
                require "profile.php";
                exit();
            }
        } else {

            $msg = "Only JPG, JPEG, PNG and GIF images are allowed";
            require "profile.php";
            exit();
        }
    } else {

        $sql = "UPDATE user_details SET
                name='$name',
                mobile='$mobile',
                email='$email',
                WHERE uid='$uid'";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {

        $role = $_SESSION['role'];

        $sql_ins = "INSERT INTO activity_log(uid,role,action)
                    VALUES('$uid','$role','updated profile')";

        mysqli_query($conn, $sql_ins);

        $msg = "Profile updated successfully";
        require "profile.php";
        exit();
    } else {

        $msg = "Profile update failed";
        require "profile.php";
        exit();
    }
}


// update password
elseif (isset($_POST['changepassword'])) {

    $uid = $_POST['uid'];
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];

    if (empty($oldpassword) || empty($newpassword) || empty($confirmpassword)) {

        $msg = "All fields are mandatory";
        require "profile.php";
        exit();
    }

    if ($newpassword != $confirmpassword) {

        $msg = "New Password and Confirm Password do not match";
        require "profile.php";
        exit();
    }

    $sql = "SELECT * FROM user_details
            WHERE uid='$uid' AND password='$oldpassword'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $sql = "UPDATE user_details
                SET password='$newpassword'
                WHERE uid='$uid'";

        $result = mysqli_query($conn, $sql);

        if ($result) {

            $role = $_SESSION['role'];

            $sql_ins = "INSERT INTO activity_log(uid,role,action)
                        VALUES('$uid','$role','changed password')";
            mysqli_query($conn, $sql_ins);

            $msg = "Password changed successfully";
            require "profile.php";
            exit();
        } else {

            $msg = "Password update failed";
            require "profile.php";
            exit();
        }
    } else {

        $msg = "Current Password is incorrect";
        require "profile.php";
        exit();
    }
}

// add comment
if (isset($_POST['add_comment'])) {

    $news_id = $_POST['news_id'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['uid'];

    $sql = "INSERT INTO comment(news_id,user_id,comments)
            VALUES('$news_id','$user_id','$comment')";

    mysqli_query($conn, $sql);

    // ye do line add karo
    $nid = $news_id;
    $_GET['nid'] = $news_id;

    require "single2.php";
    exit();
}

/* =========================
   BOOKMARK NEWS
========================= */

if (isset($_GET['book'])) {

    /* LOGIN CHECK */

    if (!isset($_SESSION['uid'])) {

        $msg = "Please login first";

        require "signin.php";

        exit;
    }


    $uid = $_SESSION['uid'];

    $news_id = $_GET['Id'];


    /* MEMBER CHECK */

    if ($_SESSION['role'] != 'member') {

        $msg = "Only members can bookmark news.";

        require "signin.php";

        exit;
    }


    /* CHECK ALREADY BOOKMARKED */

    $check_sql = "SELECT bid
                  FROM bookmark
                  WHERE user_id='$uid'
                  AND news_id='$news_id'";


    $check_result = mysqli_query(
        $conn,
        $check_sql
    );


    if (mysqli_num_rows($check_result) == 0) {


        /* INSERT BOOKMARK */

        $sql = "INSERT INTO bookmark(user_id, news_id)
                VALUES('$uid', '$news_id')";


        $result = mysqli_query(
            $conn,
            $sql
        );
    }


    /* BACK TO NEWS */

    header("Location: single2.php?nid=$news_id");

    exit;
}

if (isset($_GET['book'])) {

    if (!isset($_SESSION['uid'])) {

        $msg = "Please login first";

        require "signin.php";

        exit;
    }

    $uid = $_SESSION['uid'];
    $news_id = $_GET['Id'];

    if ($_SESSION['role'] != 'member') {

        $msg = "Only members can bookmark news.";

        require "signin.php";

        exit;
    }

    $check_sql = "SELECT bid
                  FROM bookmark
                  WHERE user_id='$uid'
                  AND news_id='$news_id'";

    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) == 0) {

        $sql = "INSERT INTO bookmark(user_id, news_id)
                VALUES('$uid', '$news_id')";

        mysqli_query($conn, $sql);
    }

    header("Location: single2.php?nid=$news_id");
    exit;
} elseif (isset($_GET['unbook'])) {

    if (!isset($_SESSION['uid'])) {

        $msg = "Please login first";

        require "signin.php";

        exit;
    }

    $uid = $_SESSION['uid'];
    $news_id = $_GET['Id'];

    $sql = "DELETE FROM bookmark
            WHERE user_id='$uid'
            AND news_id='$news_id'";

    mysqli_query($conn, $sql);

    header("Location: single2.php?nid=$news_id");
    exit;
}

// schedule and upload
if (isset($_POST['snews']) && $_POST['snews'] == "schedule") {
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $lid = $_SESSION['lid'];
    $cid = $_SESSION['cid'];

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $scheduled_publish_at = mysqli_real_escape_string($conn, $_POST['schedule_date'] ?? '');

    // Breaking News
    $breaking = isset($_POST['breaking']) ? 1 : 0;

    // Upload Image
    $filename = "newspic/" . $_FILES['nimg']['name'];
    move_uploaded_file($_FILES['nimg']['tmp_name'], $filename);

    if (empty($scheduled_publish_at)) {
        $scheduled_publish_at = date("Y-m-d H:i:s");
    }

    // Determine if scheduled time is current/past (publish immediately) or future (set scheduled)
    $is_publish = (strtotime($scheduled_publish_at) <= time()) ? 1 : 0;
    $is_scheduled = ($is_publish == 1) ? 0 : 1;

    // Schedule News Insert
    $sql = "INSERT INTO news_table (heading, n_category_id, n_location_id, description, news_image, reporter_id, is_breaking, scheduled_publish_at, is_scheduled, is_publish) VALUES ('$title', '$cid', '$lid', '$desc', '$filename', '$uid', '$breaking', '$scheduled_publish_at', '$is_scheduled', '$is_publish')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $sql_ins = "INSERT INTO activity_log (uid, role, action, affected) VALUES ('$uid', '$role', 'scheduled news', '$title')";
        mysqli_query($conn, $sql_ins);

        $msg = ($is_publish == 1) ? "News published successfully!" : "News scheduled successfully for " . date("d M Y h:i A", strtotime($scheduled_publish_at));
        require "unews.php";
    } else {
        $msg = "News scheduling failed";
        require "unews.php";
    }
}

/* =========================
   NORMAL UPLOAD NEWS
   ========================= */
if (isset($_POST['snews']) && $_POST['snews'] == "submit") {
    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $lid = $_SESSION['lid'];
    $cid = $_SESSION['cid'];

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);

    // Upload Image
    $filename = "newspic/" . $_FILES['nimg']['name'];
    move_uploaded_file($_FILES['nimg']['tmp_name'], $filename);

    // Breaking News
    $breaking = isset($_POST['breaking']) ? 1 : 0;

    // Normal News Insert
    $sql = "INSERT INTO news_table (heading, n_category_id, n_location_id, description, news_image, reporter_id, is_breaking) VALUES ('$title', '$cid', '$lid', '$desc', '$filename', '$uid', '$breaking')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $sql_ins = "INSERT INTO activity_log (uid, role, action, affected) VALUES ('$uid', '$role', 'uploaded news', '$title')";
        mysqli_query($conn, $sql_ins);

        $msg = "News uploaded successfully";
        require "unews.php";
    } else {
        $msg = "News upload failed";
        require "unews.php";
    }
}
//    DELETE NEWS
if (isset($_GET['delnews'])) {
    $nid = $_GET['delnews'];
    $sql = "UPDATE news_table SET is_delete = 1, is_scheduled = 0, scheduled_publish_at = NULL
            WHERE nid = '$nid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('News deleted successfully!');</script>";
        require "newsnv.php";
    } else {
        echo "<script>alert('News delete failed!');window.history.back();</script>";
    }
}

if (isset($_GET['likem'])) {
    require "like.php";
}

if (isset($_GET['commentm'])) {
    require "comment.php";
}

// delete like

if (isset($_GET['delete_like'])) {

    $lid = $_GET['delete_like'];
    $uid = $_SESSION['uid'];

    $sql = "DELETE FROM `likes`
            WHERE like_id = '$lid'
            AND user_id = '$uid'";

    mysqli_query($conn, $sql);

    // header("Location: db.php?like");
    require "like.php";
    exit;
}

// delete comment
if (isset($_GET['delete_comment'])) {
    $comid = $_GET['delete_comment'];
    $uid = $_SESSION['uid'];
    $sql = "DELETE FROM `comment`
            WHERE com_id = '$comid'
            AND user_id = '$uid'";

    mysqli_query($conn, $sql);
    require "comment.php";
    exit;
}

if (isset($_GET['bookmarkm'])) {
    require "bookmark.php";
    exit;
}

// delete bookmark

if (isset($_GET['delete_bookmark'])) {

    $bid = $_GET['delete_bookmark'];

    $uid = $_SESSION['uid'];

    $sql = "DELETE FROM `bookmark`
            WHERE bid = '$bid'
            AND user_id = '$uid'";

    mysqli_query($conn, $sql);

    require "bookmark.php";
    exit;
}

// Fallback if db.php is accessed directly without action parameters
if (basename($_SERVER['PHP_SELF']) === 'db.php' && empty($_POST) && empty($_GET) && empty($data)) {
    header("Location: index.php");
    exit;
}
