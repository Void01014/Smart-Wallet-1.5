<?php
$data = json_decode(file_get_contents("php://input"), true);

if ($data['otp'] == $_SESSION['otp'] && $data['otp_id'] == $_SESSION['otp_id']) {
    $_SESSION['logged_in'] = true;
    $_SESSION['login_id'] = $data['otp_id'];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
