<?php
include("database.php");
include("verifyUser.php");
include("verifyOtp.php");

    require_once __DIR__ . "/Classes/Database.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="js/signIn.js" defer></script>
    <title>Smart Wallet</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<script>
</script>

<body class="relative flex justify-center font-mono">
    <main class="md:w-[30%] h-[100vh]">
        <div class="flex justify-center items-center overlay absolute left-0 h-[100vh] w-[100vw] bg-[#00000070] hidden" id="overlay" aria-hidden="true">
            <div class="modal bg-white w-[500px] rounded-2xl p-10 flex flex-col items-center gap-4">
                <h2 class="text-2xl" id="modalTitle">Verification</h2>
                <h4>Please enter the code sent to your email</h4>
                <input class="bg-white rounded-lg p-2 px-7 w-30 border" placeholder="ex:041214" type="text" name="otp" id="otp">
                <button class="border py-2 px-5 bg-cyan-400 rounded-[15px] color-white" onclick="verify()">Verify</button>
            </div>
        </div>

        <form action="signIn.php" method="post" class="flex flex-col items-center gap-5 h-full bg-cyan-400 shadow-[0_0_20px_gray] p-15" id="form">
            <h1 class="text-4xl text-center text-white mt-20">Sign In</h1>
            <div class="w-full">
                <label for="email">Email</label>
                <input class="bg-white rounded-lg p-2 w-full" placeholder="email" type="text" name="email" id="email">
            </div>
            <div class="w-full">
                <label for="password">password</label>
                <input class="bg-white rounded-lg p-2 w-full" placeholder="password" type="password" name="password" id="password">
            </div>
            <button class="w-50 bg-white p-2 rounded-lg mt-10 hover:shadow-[0_0_10px_gray] hover:bg-blue-500 hover:scale-110 hover:text-white transition duration-200 cursor-pointer" type="submit" name="signIn">Sign In</button>
            <a class="underline" href="signUp.php">Sign Up</a>
        </form>
    </main>

    <?php
    if (isset($_POST["signIn"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $sql = "SELECT id, username, email, password
                    FROM users WHERE email = :email";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) { 
                $id = $row['id'];
                $stored_hash = $row['password'];
                $fetched_email = $row['email'];
                $username = $row['username'];
                
                if (password_verify($password, $stored_hash)) {
                    echo "<script>
                            window.location.href = 'index.php';
                        </script>";
                } else {
                    echo "<script>Swal.fire({icon: 'error', title: 'Oops...', text: 'The password or email is wrong'}).then(() => {
                  window.location.href = 'signIn.php';
                  });</script>";
                }
            }
            else{
                echo "<script>Swal.fire({icon: 'error', title: 'Oops...', text: 'The email you entered is not registered'}).then(() => {
              window.location.href = 'signIn.php';
              });</script>";
            }
    }
    ?>
</body>

</html>