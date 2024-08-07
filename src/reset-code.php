<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto mt-10">
        <div class="flex justify-center">
            <div class="w-full md:w-1/2 lg:w-1/3 bg-white p-8 rounded-lg">
                <form action="reset-code.php" method="POST" autocomplete="off">
                    <h2 class="text-center text-2xl font-bold mb-4">Code Verification</h2>

                    <?php if(isset($_SESSION['info'])): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 rounded"
                        role="alert">
                        <?= $_SESSION['info'] ?>
                    </div>
                    <?php endif; ?>

                    <?php if(count($errors) > 0): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded" role="alert">
                        <?php foreach($errors as $showerror): ?>
                        <?= $showerror ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline"
                            type="number" name="otp" placeholder="Enter code" required>
                    </div>

                    <div class="mb-4">
                        <input class="bg-blue-500 text-white px-4 py-2" type="submit"
                            name="check-reset-otp" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

