<?php require_once "controllerUserData.php"; ?>
<?php
$email = $_SESSION['email'];
if ($email == false) {
    header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create a New Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-20">
        <div class="w-full max-w-md mx-auto">
            <form action="new-password.php" method="POST" autocomplete="off"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h2 class="text-2xl font-bold text-center mb-4">New Password</h2>
                <?php if (isset($_SESSION['info'])) : ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center">
                    <?php echo $_SESSION['info']; ?>
                </div>
                <?php endif; ?>
                <?php if (count($errors) > 0) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center">
                    <?php foreach ($errors as $showerror) : ?>
                    <?php echo $showerror; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <div class="mb-4">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3" type="password"
                        name="password" placeholder="Create new password" required>
                </div>
                <div class="mb-4">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3" type="password"
                        name="cpassword" placeholder="Confirm your password" required>
                </div>
                <div class="mb-6">
                    <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
                        type="submit" name="change-password" value="Change">
                </div>
            </form>
        </div>
    </div>
</body>

</html>
