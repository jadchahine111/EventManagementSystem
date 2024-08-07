<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php require_once "controllerUserData.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="max-w-md w-full bg-white p-4 md:p-8 rounded-3xl text-center">

        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" class="mx-auto mb-4">
            <path fill="blue" d="M32.25 6H29v2h3v22H4V8h3V6H3.75A1.78 1.78 0 0 0 2 7.81v22.38A1.78 1.78 0 0 0 3.75 32h28.5A1.78 1.78 0 0 0 34 30.19V7.81A1.78 1.78 0 0 0 32.25 6Z" class="clr-i-outline clr-i-outline-path-1" />
            <path fill="blue" d="M8 14h2v2H8z" class="clr-i-outline clr-i-outline-path-2" />
            <path fill="blue" d="M14 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-3" />
            <path fill="blue" d="M20 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-4" />
            <path fill="blue" d="M26 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-5" />
            <path fill="blue" d="M8 19h2v2H8z" class="clr-i-outline clr-i-outline-path-6" />
            <path fill="blue" d="M14 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-7" />
            <path fill="blue" d="M20 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-8" />
            <path fill="blue" d="M26 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-9" />
            <path fill="blue" d="M8 24h2v2H8z" class="clr-i-outline clr-i-outline-path-10" />
            <path fill="blue" d="M14 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-11" />
            <path fill="blue" d="M20 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-12" />
            <path fill="blue" d="M26 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-13" />
            <path fill="blue" d="M10 10a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" class="clr-i-outline clr-i-outline-path-14" />
            <path fill="blue" d="M26 10a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" class="clr-i-outline clr-i-outline-path-15" />
            <path fill="blue" d="M13 6h10v2H13z" class="clr-i-outline clr-i-outline-path-16" />
            <path fill="none" d="M0 0h36v36H0z" />
        </svg>

        <div class="text-4xl font-bold mb-4 md:mb-8">Register as User</div>

        <form action="signup-user.php" method="POST" autocomplete="">
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
            

                <!-- First Name -->
                <div class="form-group">
                    <label for="first_name" class="block text-left text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" required value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>">
                </div>

                <!-- Last Name -->
                <div class="form-group">
                    <label for="last_name" class="block text-left text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" required value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>">
                </div>

                <!-- File No -->
                <div class="form-group">
                    <label for="file_no" class="block text-left text-sm font-medium text-gray-700">FileNo</label>
                    <input type="text" id="file_no" name="fileno" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500"  value="<?php echo isset($_POST['fileno']) ? $_POST['fileno'] : ''; ?>">
                    <small class="text-gray-500 mb-4">for LU students</small>
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label for="phone_number" class="block text-left text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="number" id="phone_number" name="phone_number" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500"  value="<?php echo isset($_POST['phone_number']) ? $_POST['phone_number'] : ''; ?>">
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="block text-left text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                    <small class="text-gray-500 mb-4">Example: john.doe@gmail.com</small>
                </div>

            <!-- Faculty -->
            <div class="form-group">
                <label for="faculty" class="block text-left text-sm font-medium text-gray-700">Faculty</label>
                <select onchange="getMajors(this.value)" name="faculty" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" >
                    <option value="Agronomy" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Agronomy') ? 'selected' : ''; ?>>Agronomy</option>
                    <option value="Dental Medicine" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Dental Nedicine') ? 'selected' : ''; ?>>Dental Medicine</option>
                    <option value="Economics and Business Administration" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Economics and Business Administration') ? 'selected' : ''; ?>>Economics and Business Administration</option>
                    <option value="Engineering" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
                    <option value="Fine Arts and Architecture" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Fine Arts and Architecture') ? 'selected' : ''; ?>>Fine Arts and Architecture</option>
                    <option value="Information" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'information') ? 'selected' : ''; ?>>Information</option>
                    <option value="Law and Political and Administrative Sciences" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Law and Political and Administrative Sciences') ? 'selected' : ''; ?>>Law and Political and Administrative Sciences</option>
                    <option value="Letters and Human Sciences" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Letters and Human Sciences') ? 'selected' : ''; ?>>Letters and Human Sciences</option>
                    <option value="Medical Sciences" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Medical Sciences') ? 'selected' : ''; ?>>Medical Sciences</option>
                    <option value="Pedagogy" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Pedagogy') ? 'selected' : ''; ?>>Pedagogy</option>
                    <option value="Pharmacy" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Pharmacy') ? 'selected' : ''; ?>>Pharmacy</option>
                    <option value="Public Health" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Public Health') ? 'selected' : ''; ?>>Public Health</option>
                    <option value="Sciences" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Sciences') ? 'selected' : ''; ?>>Sciences</option>
                    <option value="Technology" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Technology') ? 'selected' : ''; ?>>Technology</option>
                    <option value="Tourism and Hospitality Management" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'tourism_and_hospitality_management') ? 'selected' : ''; ?>>Tourism and Hospitality Management</option>
                    <option value="Institute of Social Science" <?php echo (isset($_POST['faculty']) && $_POST['faculty'] == 'Institute of Social Science') ? 'selected' : ''; ?>>Institute of Social Science</option>
                    <!-- Add more options as needed -->
                </select>
                <small class="text-gray-500 mb-4">for LU students</small>
            </div>

                <!-- Major -->
                <div class="form-group">
                    <label for="major" class="block text-left text-sm font-medium text-gray-700">Major</label>
                    <select name="major" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500" >
                        <option value=""></option>
                    </select>
                    <small class="text-gray-500 mb-4">for LU students</small>
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
                    <button type="submit" name="signup" class="w-full bg-blue-500 text-white font-bold py-3.5 rounded-xl block mt-5">SignUp</button>
                </div>

                <p class="text-gray-500 mb-4">Already a member? <a href="login-user.php" class="text-blue-500">Login here</a></p>
            </div>

        </form>
    </div>

</body>

</html>





        
