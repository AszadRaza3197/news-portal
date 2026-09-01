<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['uid'])) {
    header("Location: signin.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "news");
$role = $_SESSION['role'] ?? '';
if ($role == 'admin') {
    include "admin_header.php";
} elseif ($role == 'editor') {
    include "editor_header.php";
} elseif ($role == 'reporter') {
    include "reporter_header.php";
} elseif ($role == 'member') {
    include "member_header.php";
}


$msg = "";
$succ = "";

if (isset($_POST['send'])) {
    $from_id = intval($_SESSION['uid']);
    $to_id = intval($_POST['to_id'] ?? 0);
    $message = mysqli_real_escape_string($conn, $_POST['message'] ?? '');

    $attachment = "";

    if (!empty($_FILES['attachment']['name'])) {
        $clean_filename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $_FILES['attachment']['name']);
        $attachment = time() . "_" . $clean_filename;
        move_uploaded_file($_FILES['attachment']['tmp_name'], "img/" . $attachment);
    }

    if ($to_id > 0 && !empty($message)) {
        $sql = "INSERT INTO internal_chat(from_id,to_id,message,attachment)
                VALUES('$from_id','$to_id','$message','$attachment')";

        if (mysqli_query($conn, $sql)) {
            $succ = "Message Sent Successfully";
        } else {
            $msg = mysqli_error($conn);
        }
    } else {
        $msg = "Please select a recipient and enter a message.";
    }
}




$uid = intval($_SESSION['uid']);
$sql = "SELECT * FROM user_details u WHERE u.uid != '$uid' AND u.is_deleted = 0 ORDER BY u.role, u.name";
$users = mysqli_query($conn, $sql);
?>

<div class="container-fluid mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fa fa-comments me-2"></i>Internal Chat
            </h4>
        </div>

        <div class="card-body">
            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" id="chatTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#compose" role="tab"><i class="fa fa-edit mr-1"></i> Compose</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#inbox" role="tab"><i class="fa fa-inbox mr-1"></i> Inbox</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#sent" role="tab"><i class="fa fa-paper-plane mr-1"></i> Sent</a>
                </li>
            </ul>
            <div class="tab-content">

                <!-- compose -->

                <div class="tab-pane fade show active" id="compose">

                    <p class="text-danger"><?php if (!empty($msg)) echo $msg; ?></p>
                    <p class="text-success"> <?php if (!empty($succ)) echo $succ; ?></p>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">To</label>
                            <select class="form-select" name="to_id">
                                <option value="">-- Select Email --</option>
                                <?php foreach ($users as $row) { ?>
                                    <option value="<?php echo $row['uid']; ?>">
                                        <?php echo $row['email']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Attachment</label>
                            <input type="file" class="form-control" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="7" name="message"></textarea>
                        </div>
                        <button type="submit" name="send" class="btn btn-primary">
                            <i class="fa fa-paper-plane"></i> Send Message</button>
                    </form>
                </div>

                <!-- inbox -->

                <?php
                $uid = $_SESSION['uid'];

                $sql = "SELECT * FROM internal_chat 
                INNER JOIN user_details ON internal_chat.from_id = user_details.uid  
                WHERE internal_chat.to_id = '$uid' AND internal_chat.is_delete = 0 ORDER BY internal_chat.date DESC";
                $inbox = mysqli_query($conn, $sql);
                ?>
                <div class="tab-pane fade" id="inbox">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="20%">From</th>
                                <th width="35%">Message</th>
                                <th width="15%">Attachment</th>
                                <th width="20%">Date</th>
                                <th width="10%">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inbox as $row) { ?>
                                <tr>
                                    <td> <?php echo $row['email']; ?></td>
                                    <td><?php echo $row['message']; ?></td>
                                    <td>
                                        <?php
                                        if ($row['attachment'] != "") {
                                        ?>
                                            <a href="img/<?php echo $row['attachment']; ?>" download class="btn btn-sm btn-success">
                                                <i class="fa fa-download"></i> Download Attachment
                                            </a>
                                        <?php
                                        } else {
                                            echo "No Attachment";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $row['date']; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#mail<?php echo $row['message_id']; ?>">View</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- model of inbox -->

                <?php foreach ($inbox as $row) { ?>
                    <div class="modal fade" id="mail<?php echo $row['message_id']; ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"> Inbox Message </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>From :<?php echo $row['name']; ?></p>
                                    <p>Email :<?php echo $row['email']; ?></p>
                                    <p>Date :<?php echo $row['date']; ?></p>
                                    <hr>
                                    <p><?php echo $row['message']; ?></p>

                                    <?php
                                    if ($row['attachment'] != "") {
                                    ?>
                                        <hr>
                                        <b>Attachment :</b>
                                        <br><br>
                                        <img src="img/<?php echo $row['attachment']; ?>" alt="Attachment" class="img-fluid rounded border" style="max-width:400px; max-height:400px;">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- SENT -->

                <?php
                $uid = $_SESSION['uid'];

                $sql = "SELECT * FROM internal_chat 
                INNER JOIN user_details ON internal_chat.to_id = user_details.uid 
                WHERE internal_chat.from_id = '$uid' AND internal_chat.is_delete = 0 ORDER BY internal_chat.date DESC";
                $sent = mysqli_query($conn, $sql);
                ?>
                <div class="tab-pane fade" id="sent">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="20%">To</th>
                                <th width="35%">Message</th>
                                <th width="15%">Attachment</th>
                                <th width="20%">Date</th>
                                <th width="10%">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sent as $row) { ?>
                                <tr>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['message'] ?></td>
                                    <td>
                                        <?php
                                        if ($row['attachment'] != "") {
                                        ?>
                                            <a href="img/<?php echo $row['attachment']; ?>" download class="btn btn-sm btn-success">
                                                <i class="fa fa-download"></i> Download Attachment
                                            </a>
                                        <?php
                                        } else {
                                            echo "No Attachment";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row['date']; ?></td>
                                    <td><button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#sent<?php echo $row['message_id']; ?>">View</button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!--  Modal  -->

                <?php foreach ($sent as $row) { ?>
                    <div class="modal fade" id="sent<?php echo $row['message_id']; ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Sent Message</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>To :<?php echo $row['name']; ?></p>
                                    <p>Email :<?php echo $row['email']; ?></p>
                                    <p>Date:<?php echo $row['date']; ?></p>
                                    <hr>

                                    <p>Message : <?php echo $row['message']; ?></p>
                                    <?php
                                    if ($row['attachment'] != "") {
                                    ?>
                                        <hr>
                                        <b>Attachment :</b>
                                        <br><br>
                                        <img src="img/<?php echo $row['attachment']; ?>" alt="Attachment" class="img-fluid rounded border" style="max-width:400px; max-height:400px;">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>