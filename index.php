<?php
    include("database.php");
    include("verifyUser.php")
?>
<script>
    const test = "<?php echo $test ?>"
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="js/dashboard_JS.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Manager</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="md:flex font-mono md:h-[164%]">
    <?php
        include("navbar.php");
    ?>
    <main class="flex justify-center gap-20 flex-wrap p-[5rem_2rem] md:p-20  w-[100vw] h-max bg-cyan-400">
        <?php
        $inc_sql = "SELECT SUM(amount) AS inc_total FROM income";
        $exp_sql = "SELECT SUM(amount) AS exp_total FROM expense";
        $inc_stmt = $pdo->query($inc_sql);
        $exp_stmt = $pdo->query($exp_sql);

        $inc_row = $inc_stmt->fetch(PDO::FETCH_ASSOC);
        $inc_total = $inc_row['inc_total'];
        
        $exp_row = $exp_stmt->fetch(PDO::FETCH_ASSOC);
        $exp_total = $exp_row['exp_total'];

        $balance = $inc_total - $exp_total;

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
            echo "<h2 class='text-4xl text-green-500'>{$inc_total} Dh</h2>";
            ?>
            <h2 class="text-3xl">Total Expenses:</h2>
            <?php
            echo "<h2 class='text-4xl text-red-500'>{$exp_total} Dh</h2>";
            ?>
        </section>
        <?php
        $current_year = date("Y");
        $current_month = date("m");

        function select($pdo, $mode, $current_year, $current_month)
        {
            $sql2 = "SELECT '$mode' AS mode, amount,date
                            FROM $mode
                            WHERE YEAR(date) = $current_year AND MONTH(date) = $current_month
                            ";


            return $pdo->query($sql2);
        }
        
        
        $inc_amounts = array_fill(0, 31, 0);
        $inc_results = select($pdo, "income", $current_year, $current_month);
        foreach($inc_results->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $day = (int)date('j', strtotime($row['date'])) -1;
            $inc_amounts[$day] = (float)$row['amount'];
        }

        $exp_amounts = array_fill(0, 31, 0);
        $exp_results = select($pdo, "expense", $current_year, $current_month);
        foreach($exp_results->fetchAll(PDO::FETCH_ASSOC) as $row){
            $day = (int)date('j', strtotime($row['date'])) - 1; 
            $exp_amounts[$day] = (float)$row['amount'];
        }
        ?>
        <script>
            let inc_amounts = <?php echo json_encode($inc_amounts); ?>;
            let exp_amounts = <?php echo json_encode($exp_amounts); ?>;
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
            $sql3 = "SELECT 'income' AS mode, id, category, amount, date, description
                        FROM income
                        UNION ALL
                        SELECT 'expense' AS mode, id, category, amount, date, description
                        FROM expense
                        ORDER BY id;";

            $results = $pdo->query($sql3);
            while ($row = $results->fetch(PDO::FETCH_ASSOC  )) {
                $color = $row["mode"] == 'income' ? '[#00fa00]' : "[#fa0000d9]";
                echo '<tr class="bg-blue-100 text-[10px] md:text-[20px] rows " id=' . $row["id"] . ' data-mode=' . $row["mode"] . '>
                            <td  class=" . text-' . $color . ' category">' . $row["category"] .'</td>
                            <td  class=" . text-' . $color . ' amount">' . $row["amount"] . ' Dh' .'</td>
                            <td  class=" . text-' . $color . ' desc">' . $row["description"] .'</td>
                            <td  class=" . text-' . $color . ' date">' . $row["date"] .'</td>
                        </tr>';
            }
            ?>
        </table>


    </main>
</body>

</html>