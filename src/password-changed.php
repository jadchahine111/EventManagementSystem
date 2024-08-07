<?php require_once "controllerUserData.php"; ?>

<?php
if ($_SESSION['info'] == false) {
    header('Location: login-user.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto flex justify-center items-center h-screen">
        <div class="w-full md:w-1/2 lg:w-1/3 px-4">
            <div class="bg-white p-8 rounded-md shadow-md">
                <?php if (isset($_SESSION['info'])): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 rounded text-center">
                        <?= $_SESSION['info']; ?>
                    </div>
                <?php endif; ?>

                <form action="login-user.php" method="POST" class="form login-form">
                    <div class="mb-4">
                        <input class="w-full px-3 py-2 bg-blue-500 text-white rounded-md" type="submit" name="login-now" value="Login Now">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>


