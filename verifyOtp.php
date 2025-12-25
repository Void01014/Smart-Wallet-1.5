<?php
$data = json_decode(file_get_contents("php://input"), true);

echo $data;
print_r($data);

// if (1) {
//     $_SESSION['logged_in'] = true;
//     $_SESSION['login_id'] = $data['otp_id'];
//     echo json_encode(['success' => true]);
// } else {
//     echo json_encode(['success' => false]);
//     echo "nope";
// }
