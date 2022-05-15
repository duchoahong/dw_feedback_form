<?php include("phpconnection.php"); ?>

<!DOCTYPE html>
<html>
<head>
	<title>feedback from students.</title>
    <link rel="stylesheet" href="./public/vendor/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>

<div class="container">
    <br>
    <div class="d-flex justify-content-between">
        <div>
            <h1 class="text-center">Feedback List.</h1>
        </div>
        <div>
            <button class="btn btn-success"  data-toggle="modal" data-target="#addFeedbackModal">Add Feedback</button>
        </div>
    </div>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>email</th>
                <th>teplephone</th>
                <th>content</th>
                <th>status</th>
                <th>created_date</th>
                <!-- <th>edit</th>
                <th>Delete</th> -->
            </tr>
        </thead>
        <tbody>
            <?php 
                $result = mysqli_query($conn, "SELECT  * FROM dw_student;") or die(mysqli_error());
                while ($row = mysqli_fetch_array($result)) {
                    $status = null;
                    if ($row['status']) {
                        $status = "<span class='text-success'>read</span>";
                    } else {
                        $status = "<span class='text-danger'>unread</span>";
                    }
                    
                    echo "<tr>"
                            ."<td >". $row['id'] ."</td>"
                            ."<td >". $row['name'] ."</td>"
                            ."<td >". $row['email'] ."</td>"
                            ."<td >". $row['telephone'] ."</td>"
                            ."<td >". $row['content'] ."</td>"
                            ."<td >". $status ."</td>"
                            ."<td >". $row['created_date'] ."</td>";
                            // ."<td >". "<button class='btn btn-success edit_decor' onClick='editFunc(\"edit_user.php?ID=".$row['id']."\")'>edit</button>"
                            // ."<td >". "<span class='btn btn-danger delete_decor' onClick='deleteConfirm(\"users_del.php?del_id=".$row['id']."\")'>delete</span>" ."</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="addFeedbackModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form>
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="student-name" class="col-form-label">Student Name:</label>
                    <input type="text" name="student_name" class="form-control" id="student-name">
                </div>
                <div class="form-group">
                    <label for="student-email" class="col-form-label">Student Email:</label>
                    <input type="text" name="student_email" class="form-control" id="student-email">
                </div>
                <div class="form-group">
                    <label for="student-telephone" class="col-form-label">Student Telephone:</label>
                    <input type="text" name="student_telephone" class="form-control" id="student-telephone">
                </div>
                <div class="form-group">
                    <label for="feedback_content" class="col-form-label">Feedback Content:</label>
                    <textarea name="feedback_content" class="form-control" id="feedback_content" rows="15"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary send-feedback">Send Feedback</button>
            </div>
            </div>
        </form>
    </div>
</div>
<!-- end Modal -->

<script src="./public/vendor/jquery/jquery-3.6.0.min.js"></script>
<script src="./public/vendor/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
<script Language='javascript'>
    $(".send-feedback").click(function(e) {
        e.preventDefault()

        var form = $(this).closest("form");
        var payload = getAllValues(form);

        console.log("payload", payload)

        $.ajax({
            type: "POST",
            url: 'add_feedback.php',
            data: payload,
            success: function(response)
                {
                    response = JSON.parse(response);
                    console.log("AJAX repsonse: ", response)
                    console.log("AJAX repsonse: ", response.status)

                    if (response.status) {
                        alert(response.message);
                        window.location.reload();
                    } else {
                        alert(response.message);
                    }
            }
       });
    })
    
    /**
     * ================
     * Helpers Function
     * $ Debuger Boyz $
     * ================
     */
    function getAllValues(form) {
        var allVal = {};
        $(form)
            .find(":input")
            .each(function () {
            var type = $(this).prop("type");
            var obj_key = $(this).attr("name");
            var obj_val = $(this).val();

            if (["button", "submit"].includes(type)) return;
            // console.log("typeof obj_key", typeof obj_key);

            switch (type) {
                case "tel":
                allVal[obj_key] = obj_val.split(".").join("");
                break;
                case "checkbox":
                if (!$(this).is(":checked")) return;
                allVal[`${obj_key}`]
                    ? (allVal[`${obj_key}`] = [...allVal[`${obj_key}`], obj_val])
                    : (allVal[`${obj_key}`] = [obj_val]);
                break;
                default:
                allVal[obj_key] = obj_val;
                break;
            }
            });

        // console.log("===== allVal ====", allVal);

        return allVal;
    }
</script>

</body>
</html>

<?php $conn->close(); ?>