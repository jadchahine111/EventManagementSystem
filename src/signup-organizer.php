<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "controllerUserData.php"; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Organizer Signup Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="max-w-md w-full bg-white p-4 md:p-8 rounded-3xl text-center">

        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" class="mx-auto mb-4">
            <!-- Your SVG Path Data -->
        </svg>

        <div class="text-4xl font-bold mb-4 md:mb-8">Organizer Signup</div>

        <form action="signup-organizer.php" method="POST" autocomplete="">
        <div class="space-y-4">

        <?php
        if (count($errors) == 1) {
            ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center">
                <?php
                foreach ($errors as $showerror) {
                    echo $showerror;
                }
                ?>
            </div>
        <?php
        } elseif (count($errors) > 1) {
        ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center">
                <?php
                foreach ($errors as $showerror) {
                    ?>
                    <li><?php echo $showerror; ?></li>
                <?php
            }
            ?>
            </div>
        <?php
        }
        ?>

                <!-- Add other common fields here (last_name, email, password, etc.) -->

                <!-- Organizer Type -->
                <div class="form-group">
                    <label for="organizer_type" class="block text-left text-sm font-medium text-gray-700">Organizer Type</label>
                    <select name="organizer_type" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" required>
                        <option value="individual">Individual</option>
                        <option value="organization">Organization</option>
                        <!-- Add other types as needed -->
                    </select>
                </div>

                <!-- Organization name -->
                <div class="form-group">
                    <label for="organization_name" class="block text-left text-sm font-medium text-gray-700">Organization Name</label>
                    <input type="text" id="organization_name" name="organization_name" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" required value="<?php echo isset($_POST['organization_name']) ? $_POST['organization_name'] : ''; ?>">
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label for="phone_number" class="block text-left text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="number" id="phone_number" name="phone_number" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" required value="<?php echo isset($_POST['phone_number']) ? $_POST['phone_number'] : ''; ?>">
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="block text-left text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                    <small class="text-gray-500 mb-4">Example: john.doe@gmail.com</small>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="block text-left text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" required>
                </div>

                <!-- Retype Password -->
                <div class="form-group">
                    <label for="retype_password" class="block text-left text-sm font-medium text-gray-700">Retype Password</label>
                    <input type="password" id="retype_password" name="cpassword" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" required>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" name="signup-organizer" class="w-full bg-blue-500 text-white font-bold py-3.5 rounded-xl block mt-5">SignUp</button>
                </div>

                <p class="text-gray-600 mb-4">Already a member? <a href="login-user.php" class="text-blue-500">Login here</a></p>
            </div>
        </form>
    </div>

</body>

</html>
