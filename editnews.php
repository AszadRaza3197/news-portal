<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($conn)) {
    $conn = mysqli_connect("localhost", "root", "", "news");
}
$nid = isset($nid) ? intval($nid) : (isset($_GET['nid']) ? intval($_GET['nid']) : 0);
include "reporter_header.php";
$sql = "select * from news_table where nid='$nid' and is_delete=0";
$result = mysqli_query($conn, $sql);
?>

<div class="container col-sm-4">
    <h2 class="text-danger text-center">edit news</h2>
    <div class="card" style="width: 28rem;">
        <div class="card-body">
            
            <form action="db.php" method="POST" enctype="multipart/form-data">
               <p style="color:red"><?php if(isset($_GET['msg'])) echo $_GET['msg'];  ?></p>
               <?php foreach($result as $row) { ?>
                <div class="form-group">
                    <label for="">News Title</label>
                    <input type="text" name="title" id="" class="form-control" value="<?php echo $row['heading'] ?>">
                </div>
                <div class="form-group">
                    <label >Upload image</label>
                    <input type="file" name="nimg" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label >Description</label>
                    <textarea name="desc" id="desc" class="form-control" rows="6"><?php echo $row['description'] ?></textarea>
                </div>
                <!-- hidden inputs for news id  details -->
                     <input type="hidden" name="nid" value="<?php echo $nid; ?>">
                    
                <div class="text-center">
                    <input type="submit" name="enews" value="submit news" class="btn btn-danger">
                </div>
                <?php } ?>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>