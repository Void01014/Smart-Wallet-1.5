<?php
include("database.php");

if(isset($_POST['id'], $_POST['mode'], $_POST['category'], $_POST['amount'], $_POST['description'], $_POST['date'])){
    $id = $_POST['id'];
    $mode = $_POST['mode'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // prepare statement
    $sql = "UPDATE $mode SET category = :category, amount = :amount, description = :description, date = :date WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'category' => $category,
        'amount'   => $amount,
        'description' => $description,
        'date' => $date,
        'id' => $id
    ]);

    echo json_encode([
        'success' => $result && $stmt->rowCount() > 0
    ]);
}
?>
