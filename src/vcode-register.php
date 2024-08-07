<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('background.jpg');
            background-color: #f0f0f0; /* Light gray background color */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the background image */
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto flex justify-center items-center h-screen">
        <div class="w-full md:w-1/2 lg:w-1/3 px-4">
            <form action="user-otp.php" method="POST" autocomplete="off" class="bg-white shadow-md rounded p-6">
                <h2 class="text-center text-2xl font-bold mb-4">Code Verification</h2>
                <?php 
                if(isset($_SESSION['info'])){
                    ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center">
                        <?php echo $_SESSION['info']; ?>
                    </div>
                    <?php
                }
                ?>
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
                <div class="mb-4">
                    <input class="w-full px-3 py-2 border rounded-md" type="number" name="otp" placeholder="Enter verification code" required>
                </div>
                <div class="mb-4">
                    <input class="w-full px-3 py-2 bg-blue-500 text-white rounded-md" type="submit" name="check" value="Submit">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
