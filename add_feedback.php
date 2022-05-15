<?php 
include("phpconnection.php");

$name = "";
$gender = "";
$age = "";
$address = "";
$status = "";
date_default_timezone_set('Asia/Ho_Chi_Minh');
$current_date = date("Y-m-d H:i:s");

$response;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(
        isset($_POST["student_name"]) && $_POST["student_name"]
        && isset($_POST["student_email"]) && $_POST["student_email"]
        && isset($_POST["student_telephone"]) && $_POST["student_telephone"]
        && isset($_POST["feedback_content"]) && $_POST["feedback_content"]
    ) { 
        $name = $_POST['student_name'];
        $email = $_POST['student_email'];
        $telephone = $_POST['student_telephone'];
        $content = $_POST['feedback_content'];
    } else {
        $response = [
            "status" => false,
            "message" => "Vui lòng điền đầy đủ thông tin."
        ];
        
        echo json_encode($response);
        return;
    }

    $sql = "INSERT INTO dw_student (name, email, telephone, content, created_date) VALUES ('$name', '$email', '$telephone', '$content', '$current_date')";
    // echo $sql;

    if ($conn->query($sql) === TRUE) {
        $response = [
            "status" => true,
            "message" => "Gửi Feedback thành công."
        ];
    } else {
        $response = [
            "status" => false,
            "message" => "Gửi Feedback thất bại."
        ];
        // return "Error: " . $sql . "<br>" . $conn->error;
    }
}

echo json_encode($response);