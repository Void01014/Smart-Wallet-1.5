<?php
include("database.php");

if(isset($_POST['id'], $_POST['mode'])){
    $id = $_POST['id']; 
    $mode = $_POST['mode'];

    $sql = "DELETE FROM $mode WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    echo json_encode(['success' => $result && mysqli_affected_rows($conn) > 0]);
}
?>