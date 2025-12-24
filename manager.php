<?php
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="js/script.js" defer></script>
    <title>Smart Wallet</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<script>
</script>

<body class="relative flex justify-center font-mono">
    <nav>
        <a class="absolute left-[calc(42vw+19vh-14rem)] top-3" href="index.php" id="home"><img class="pointer-events-none" src="img/house_icon.png" width="50" alt="home_button"></a>
    </nav>
    <main class="md:w-[30%] h-[100vh]">
        <form action="manager.php" method="post" class="flex flex-col items-center gap-5 h-full bg-cyan-400 shadow-[0_0_20px_gray] p-15" id="form">
            <input type="hidden" name="mode" value="income">
            <div class="self-end flex" id="switch">
                <button type="button" class="bg-gray-300 w-20 selected rounded-l-lg p-2 cursor-pointer" id="inc">Income</button>
                <button type="button" class="bg-gray-300 w-20 rounded-r-lg p-2 cursor-pointer" id="exp">Expenses</button>
            </div>
            <h1 class="text-4xl text-center text-white">Smart Wallet</h1>
            <div class="w-full">
                <label for="type">Type</label>
                <select name="type" id="type" class="bg-white w-full rounded-lg p-2">
                    <option value="default" disabled selected>choose a type</option>
                    <option value="salary">Salary</option>
                    <option value="freelance">Freelance</option>
                    <option value="gifts">Gifts</option>
                    <option value="investments">Investments</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="w-full">
                <label for="amount">Amount</label>
                <input class="bg-white rounded-lg p-2 w-full" placeholder="Amount" type="number" step="0.1" name="amount" id="amount">
            </div>
            <div class="w-full">
                <label for="date">Date</label>
                <input class="bg-white rounded-lg p-2 w-full" placeholder="text" type="date" name="date" id="date">
            </div>
            <div class="w-full">
                <label for="desc">Description</label>
                <input class="bg-white rounded-lg p-2 w-full" placeholder="Write a short description" type="text" name="desc" id="desc">
            </div>
            <button class="w-50 bg-white p-2 rounded-lg mt-10 hover:shadow-[0_0_10px_gray] hover:bg-blue-500 hover:scale-110 hover:text-white transition duration-200 cursor-pointer" type="submit" name="add">Add</button>
        </form>
    </main>

    <?php
    if (isset($_POST["add"])) {
        $mode = $_POST["mode"];

        function push($conn, $mode){
            $type = $_POST["type"];
            $amount = $_POST["amount"];
            $date = $_POST["date"];
            $desc = $_POST["desc"];
            $sql = "INSERT INTO $mode (type, amount, date, description)
                        VALUES (?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sdss", $type, $amount, $date, $desc);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<script>Swal.fire({icon: 'success', title: 'Operation successful', text: 'Your {$mode} has been added'}).then(() => {
                  window.location.href = 'manager.php';
                  });</script>";
        }
        
        if ($mode == "income") {
            push($conn, 'income');
        }
        if ($mode == "expense") {
            push($conn, 'expense');
        }
    }
    mysqli_close($conn);
    ?>
</body>

</html>