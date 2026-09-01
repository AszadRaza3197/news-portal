<?php include "reporter_header.php"; ?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Upload News</h4>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" id="newsForm">
                <div class="form-group">
                    <label><strong>News Heading</strong></label>
                    <input type="text" name="title" class="form-control" placeholder="Enter news heading" required>
                </div>
                <div class="form-group">
                    <label><strong>Upload Image</strong></label>
                    <input type="file" name="nimg" class="form-control" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label><strong>Description</strong></label>
                    <textarea name="desc" id="desc" class="form-control" rows="8" placeholder="Enter news description..." required></textarea>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="breaking" value="1" class="form-check-input" id="breaking">
                    <label class="form-check-label" for="breaking"><strong>Breaking News</strong></label>
                </div>
                <input type="hidden" name="schedule_date" id="schedule_date" value="">
                <input type="hidden" name="snews" id="snews" value="">
                <div class="text-center mt-4">
                    <div class="dropdown">
                        <button type="button" class="btn btn-danger dropdown-toggle" id="actionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Select Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="actionDropdown">
                            <button type="button" class="dropdown-item" id="submitNews">
                                <i class="fa fa-paper-plane mr-2"></i>Submit News
                            </button>
                            <button type="button" class="dropdown-item" id="scheduleNews">
                                <i class="fa fa-calendar mr-2"></i>Schedule News
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Schedule News Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="scheduleModalLabel">Schedule News</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>Select Date</strong></label>
                    <input type="date" id="schedule_date_input" class="form-control">
                </div>
                <div class="form-group">
                    <label><strong>Select Time</strong></label>
                    <input type="time" id="schedule_time_input" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="saveSchedule">Save Schedule</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        var today = new Date();
        var year = today.getFullYear();
        var month = String(today.getMonth() + 1).padStart(2, '0');
        var day = String(today.getDate()).padStart(2, '0');
        var todayDate = year + "-" + month + "-" + day;
        $("#schedule_date_input").attr("min", todayDate);

        $("#submitNews").click(function() {
            $("#schedule_date").val("");
            $("#snews").val("submit");
            $("#actionDropdown").text("Submit News");
            $("#newsForm").submit();
        });

        $("#scheduleNews").click(function(e) {
            e.preventDefault();
            $("#scheduleModal").modal("show");
        });

        $("#saveSchedule").click(function() {
            var date = $("#schedule_date_input").val();
            var time = $("#schedule_time_input").val();

            if (date === "") {
                alert("Please select date.");
                return;
            }
            if (time === "") {
                alert("Please select time.");
                return;
            }

            var selectedDateTime = new Date(date + "T" + time);
            var currentDateTime = new Date();

            if (selectedDateTime <= currentDateTime) {
                alert("Please select a future date and time.");
                return;
            }

            var scheduleDate = date + " " + time;
            $("#schedule_date").val(scheduleDate);
            $("#snews").val("schedule");
            $("#actionDropdown").text("Schedule News");
            $("#scheduleModal").modal("hide");
            $("#newsForm").submit();
        });
    });
</script>

<?php include "footer.php"; ?>