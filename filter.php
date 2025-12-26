<!-- <?php
include("database.php");
// session_start();
$user_id = $_SESSION['login_id'];

require_once __DIR__ . "/Classes/Category.php";

if (isset($_POST['filter'])) {
    $selectedCategory = $_POST['category'] ?? 'all';
    // Prepare query
    if ($selectedCategory === 'all') {
        $sql = "SELECT 'income' AS mode, id, category, amount, date, description
                        FROM income
                        UNION ALL
                        SELECT 'expense' AS mode, id, category, amount, date, description
                        FROM expense
                        WHERE user_id = $user_id
                        ORDER BY id";
        $stmt = $pdo->query($sql);
    } else {
        $sql = "SELECT 'income' AS mode, id, category, amount, date, description
                        FROM income
                        UNION ALL
                        SELECT 'expense' AS mode, id, category, amount, date, description
                        FROM expense
                        WHERE user_id = $user_id
                        ORDER BY id";
        $stmt = $pdo->prepare("SELECT * FROM transactions WHERE category = ? ORDER BY date DESC");
        $stmt->execute([$selectedCategory]);
    }

    $allTransactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} -->
