<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="max-w-md w-full bg-white p-4 md:p-8 rounded-3xl text-center">

        <form action="login-user.php" method="POST" autocomplete="">
            <h2 class="text-3xl font-bold mb-4">Login</h2>
            <p class="text-center text-gray-600">Login with your email and password.</p>

            <?php
            if(count($errors) > 0){
                ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center">
                    <?php
                    foreach($errors as $showerror){
                        echo $showerror;
                    }
                    ?>
                </div>
                <?php
            }
            ?>

            <div class="form-group mt-4">
                <input class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" type="email" name="email" placeholder="Email Address" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            </div>
            <div class="form-group mt-4">
                <input class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" type="password" name="password" placeholder="Password" required>
            </div>
            <div class="link forget-pass text-left mt-2"><a href="forgot-password.php" class="text-blue-500">Forgot password?</a></div>
            <div class="form-group mt-4">
                <input class="w-full bg-blue-500 text-white font-bold py-3.5 rounded-xl block" type="submit" name="login" value="Login">
            </div>
            <p class="text-gray-600 mt-4">
                Not yet a member? 
                <a href="signup-user.php" class="text-blue-500">Sign up as a User</a> 
                <br>or<br> 
                <a href="signup-organizer.php" class="text-blue-500">Sign up as an Organizer</a>
            </p>

        </form>

    </div>

</body>
</html>
