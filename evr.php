<?php
$uid=$_SESSION['uid'];
$role=$_SESSION['role'];
$lid=$_SESSION['lid'];
 $cid=$_SESSION['cid'];
   include "editor_header.php"; 

        $sql2="select u.uid,u.name,u.cat_id,u.loc_id,c.category AS category_name,l.location AS location_name from user_details u 
        LEFT JOIN category c ON u.cat_id=c.cat_id
        LEFT JOIN location l ON u.loc_id=l.loc_id
        where u.role='reporter' and u.is_verified=1 and u.is_deleted=0 and u.cat_id='$cid' and u.loc_id='$lid'";
        $result2=mysqli_query($conn,$sql2);
        $rows = mysqli_fetch_all($result2, MYSQLI_ASSOC);
?>

<h1>Verified reporters</h1>
<h5 class="text-primary"><?php if(isset($_GET['msg'])) echo $_GET['msg']; ?></h5>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="">Reporter_Name</th>
            <th class="">Reporter_Category</th>
            <th class="">Reporter_location</th>
            <th class="">Action</th>
        </tr>
    </thead>
    <?php foreach($rows as $row) { ?>
    <tbody>
        <tr>
            <td scope="col"><?php echo $row['name'] ?></td>
            <td scope="col"><?php echo $row['category_name'] ?></td>
            <td scope="col"><?php echo $row['location_name'] ?></td>
            <td scope="col"><a href="db.php?edisaprreporter=<?php echo $row['uid'] ?>" class="btn btn-primary">disapprove reporter</a> </td>
        </tr>
    </tbody>
    <?php }?>
</table>

<?php
include "footer.php";
?>
