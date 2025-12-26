<?php
include("database.php");

require_once __DIR__ . ("/Classes/Transaction.php");
require_once __DIR__ . ("/Classes/Expense.php");
require_once __DIR__ . ("/Classes/Income.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="styles.css">
    <script src="js/script.js" defer></script>
    <title>Smart Wallet</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 50%, #22d3ee 100%);
        }
        form{
            background-color: #ffffff50;
            border: 2px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(3px);
            border-radius: 30px;
        }

        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -1;
        }

        /* Geometric shapes */
        .shape {
            position: absolute;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
            border: 2px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            animation: rotate 20s infinite linear;
        }

        .shape.circle {
            border-radius: 50%;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-30px) rotate(180deg);
            }
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg) translateX(10px);
            }

            100% {
                transform: rotate(360deg) translateX(10px);
            }
        }

        /* Gradient orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
            animation: pulse 8s infinite ease-in-out;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.3;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.5;
            }
        }
    </style>
</head>

<body class="md:flex relative justify-center font-mono">

    <?php
    include("navbar.php");
    ?>
    <div class="background-container" id="bg">
        <!-- Large gradient orbs -->
        <div class="orb" style="width: 300px; height: 300px; background: #ffffffff; top: 10%; left: 20%;"></div>
        <div class="orb" style="width: 400px; height: 400px; background: #ffffffff; bottom: 10%; right: 10%;"></div>
        <div class="orb" style="width: 250px; height: 250px; background: #ffffffff; top: 50%; right: 30%; animation-delay: 2s;"></div>
    </div>

    <script>
        const bg = document.getElementById('bg');

        // Create geometric shapes
        for (let i = 0; i < 10; i++) {
            const shape = document.createElement('div');
            shape.className = 'shape' + (Math.random() > 0.5 ? ' circle' : '');
            const size = Math.random() * 100 + 50;
            shape.style.width = size + 'px';
            shape.style.height = size + 'px';
            shape.style.left = Math.random() * 100 + '%';
            shape.style.top = Math.random() * 100 + '%';
            shape.style.animationDuration = (Math.random() * 20 + 15) + 's';
            shape.style.animationDelay = Math.random() * 5 + 's';
            bg.appendChild(shape);
        }
    </script>
    <main class="md:w-[30%] h-[100vh] rounded-[30px] overflow-hidden">
        <form action="manager.php" method="post" class="flex flex-col items-center gap-5 h-full shadow-[0_0_20px_white] p-15" id="form">
            <input type="hidden" name="mode" value="income">
            <div class="self-end flex" id="switch">
                <button type="button" class="bg-gray-300 w-20 selected rounded-l-lg p-2 cursor-pointer" id="inc">Income</button>
                <button type="button" class="bg-gray-300 w-20 rounded-r-lg p-2 cursor-pointer" id="exp">Expenses</button>
            </div>
            <h1 class="text-4xl text-center text-white">Smart Wallet</h1>
            <div class="w-full">
                <label for="categody">Category</label>
                <select name="category" id="category" class="bg-white w-full rounded-lg p-2">
                    <option value="default" disabled selected>choose a Category</option>
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
        $category   = $_POST["category"];
        $amount = $_POST["amount"];
        $date   = $_POST["date"];
        $desc   = $_POST["desc"];

        $transaction = new $mode($pdo, $category, $amount, $desc, $date);

        if (!transaction::validateMode($mode)) {
            exit('Invalid mode');
        };

        if (!$transaction->validateALL()) {
            exit('Invalid transaction');
        }

        $transaction->push($pdo, $mode);

        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Operation successful',
                text: 'Your {$mode} has been added'
            }).then(() => {
                window.location.href = 'manager.php';
            });
        </script>";
    }
    ?>

</body>

</html>