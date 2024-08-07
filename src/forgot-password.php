<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="max-w-md w-full bg-white p-4 md:p-8 rounded-3xl text-center">

        <form action="forgot-password.php" method="POST" autocomplete="">
            <h2 class="text-3xl font-semibold mb-4">Forgot Password</h2>
            <p class="text-center text-gray-600">Enter your email address</p>

            <?php
            if(count($errors) > 0){
                ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center">
                    <?php 
                    foreach($errors as $error){
                        echo $error;
                    }
                    ?>
                </div>
                <?php
            }
            ?>

            <div class="form-group mt-4">
                <input class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" type="email" name="email" placeholder="Enter email address">
            </div>
            <div class="form-group mt-4">
                <input class="w-full bg-blue-500 text-white font-bold py-3.5 rounded-xl block" type="submit" name="check-email" value="Continue">
            </div>
        </form>

    </div>

</body>
</html>

