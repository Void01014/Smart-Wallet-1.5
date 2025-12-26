<?php
include("database.php");
include("verifyUser.php");

require_once __DIR__ . "/Classes/User.php";



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="js/signUp.js" defer></script>
    <title>Smart Wallet</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<script>
</script>

<body class="relative flex justify-center font-mono">
    <main class="md:w-[30%] h-[100vh]">
        <form action="signUp.php" method="post" class="flex flex-col items-center gap-5 h-full bg-cyan-400 shadow-[0_0_20px_gray] p-15" id="form">
            <h1 class="text-4xl text-center text-white mt-20">Sign Up</h1>
            <div class="w-full">
                <label for="username">Username</label>
                <input class="bg-white rounded-lg p-2 w-full" placeholder="username" type="text" name="username" id="username">
            </div>
            <div class="w-full">
                <label for="email">Email</label>
                <input class="bg-white rounded-lg p-2 w-full" placeholder="email" type="text" name="email" id="email">
            </div>
            <div class="w-full">
                <label for="password">password</label>
                <input class="bg-white rounded-lg p-2 w-full" placeholder="password" type="password" name="password" id="password">
            </div>
            <button class="w-50 bg-white p-2 rounded-lg mt-10 hover:shadow-[0_0_10px_gray] hover:bg-blue-500 hover:scale-110 hover:text-white transition duration-200 cursor-pointer" type="submit" name="signUp">Sign Up</button>
            <a class="underline" href="signIn.php">Sign in</a>
        </form>
    </main>

    <?php
    if (isset($_POST["signUp"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $user = new user($pdo);
        $user->setName($username);
        $user->setEmail($email);
        $user->setpassword($hash);
        
        if (!$user->validateAll()) {
            header("Location: register.php");
            exit;
        }

        $user->push();

        echo "<script>Swal.fire({icon: 'success', title: 'Good Job', text: 'Your account was created successfully'}).then(() => {
              window.location.href = 'index.php';
              });</script>";
    }
    ?>
</body>

</html>