<?php
include("database.php");
include("verifyUser.php");

require_once __DIR__ . ("/Classes/TransactionRepositorie.php")
?>
<script>
    const test = "<?php echo $test ?>"
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="js/dashboard_JS.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Manager</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="md:flex font-mono md:h-[166%]">
    <?php
    include("navbar.php");
    ?>
    <main class="flex justify-center gap-20 flex-wrap p-[5rem_2rem] md:p-20  w-[100vw] h-max bg-cyan-400">
        <?php
        $repo = new TransactionRepositorie($pdo);

        $allTransactions = $repo->getAllByUser($_SESSION['login_id']);
        
        $totalIncome = $repo->getTotals($allTransactions)['income'];
        $totalExpense = $repo->getTotals($allTransactions)['expense'];
        $balance = $repo->getTotals($allTransactions)['balance'];

        ?>
        <section class="flex flex-col items-center justify-center gap-7 w-120 h-70 bg-white rounded-2xl shadow-[0_0_10px_gray]" id="balance">
            <h2 class="text-5xl text-blue-700 text-center">Current balance:</h2>
            <?php
            echo "<h2 class='text-6xl'>{$balance} Dh</h2>";
            ?>
        </section>
        <section class="flex justify-center gap-2 p-5 flex-wrap w-80 h-70 bg-white rounded-2xl shadow-[0_0_10px_gray]" id="total_stats">
            <h2 class="text-3xl">Total Income:</h2>
            <?php
            echo "<h2 class='text-4xl text-green-500'>{$totalIncome} Dh</h2>";
            ?>
            <h2 class="text-3xl">Total Expenses:</h2>
            <?php
            echo "<h2 class='text-4xl text-red-500'>{$totalExpense} Dh</h2>";
            ?>
        </section>
        <?php
            $monthIncome = $repo->getMonthStats()['income'];
            $monthExpense = $repo->getMonthStats()['expense'];
        ?>
        <script>
            let inc_amounts = <?php echo json_encode($monthIncome); ?>;
            let exp_amounts = <?php echo json_encode($monthExpense); ?>;
        </script>

        <section class="w-full h-max md:w-[70%] bg-white rounded-xl shadow-[0_0_15px_gray]" id="grah_section">
            <canvas id="graph"></canvas>
        </section>
        <table class="w-[100%] h-70 rounded-2xl shadow-[0_0_10px_gray] bg-blue-400  text-center rounded-3xl overflow-hidden text-white" id="table">
            <tr class="h-15 bg-blue-400 text-center">
                <th>category</th>
                <th>amount</th>
                <th>description</th>
                <th>date</th>
            </tr>
            <?php
            foreach($allTransactions as $row) {
                $color = $row["mode"] == 'income' ? '[#00fa00]' : "[#fa0000d9]";
                echo '<tr class="bg-blue-100 text-[10px] md:text-[20px] rows " id=' . $row["id"] . ' data-mode=' . $row["mode"] . '>
                                <td  class="text-' . $color . ' category">' . $row["category"] . '</td>
                                <td  class="text-' . $color . ' amount">' . $row["amount"] . ' Dh' . '</td>
                                <td  class="text-' . $color . ' desc">' . $row["description"] . '</td>
                                <td  class="text-' . $color . ' date">' . $row["date"] . '</td>
                            </tr>';
            }

            ?>
        </table>
    </main>
</body>

</html>