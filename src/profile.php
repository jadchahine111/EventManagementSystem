<?php 
require_once "controllerUserData.php"; 
?>
<?php 
$email = $_SESSION['email'];
$password = $_SESSION['password'];
if($email != false && $password != false){
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $profilePicPath = $fetch_info['profile_pic'];
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        $isAdmin = $fetch_info['is_admin'];
        $first_name = $fetch_info['first_name'];
        $last_name = $fetch_info['last_name'];
        $phone_number = $fetch_info['phone_number'];
        if($status == "verified"){
            if($code != 0){
                header('Location: reset-code.php');
            }
        }else{
            header('Location: user-otp.php');
        }
    }
}else{
    header('Location: login-user.php');
}

?>

















<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile</title>

  <!-- Tailwind is included -->
  <link rel="stylesheet" href="css/main.css?v=1628755089081">

  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png"/>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png"/>
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png"/>
  <link rel="mask-icon" href="safari-pinned-tab.svg" color="#00b4b6"/>

  <meta name="description" content="Admin One - free Tailwind dashboard">

  <meta property="og:url" content="https://justboil.github.io/admin-one-tailwind/">
  <meta property="og:site_name" content="JustBoil.me">
  <meta property="og:title" content="Admin One HTML">
  <meta property="og:description" content="Admin One - free Tailwind dashboard">
  <meta property="og:image" content="https://justboil.me/images/one-tailwind/repository-preview-hi-res.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="1920">
  <meta property="og:image:height" content="960">

  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:title" content="Admin One HTML">
  <meta property="twitter:description" content="Admin One - free Tailwind dashboard">
  <meta property="twitter:image:src" content="https://justboil.me/images/one-tailwind/repository-preview-hi-res.png">
  <meta property="twitter:image:width" content="1920">
  <meta property="twitter:image:height" content="960">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130795909-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-130795909-1');
  </script>

</head>
<body>

<div id="app">

<nav id="navbar-main" class="navbar is-fixed-top">
  <div class="navbar-brand">
    <a class="navbar-item mobile-aside-button">
      <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
    </a>
  </div>
  <div class="navbar-brand is-right">
    <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
      <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
    </a>
  </div>
  <div class="navbar-menu" id="navbar-menu">
    <div class="navbar-end">
      <div class="navbar-item dropdown has-divider">
        <div class="navbar-dropdown">
          <a href="profile.html" class="navbar-item">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span>My Profile</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-settings"></i></span>
            <span>Settings</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-email"></i></span>
            <span>Messages</span>
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item" href="logout-user.php">
            <span class="icon"><i class="mdi mdi-logout"></i></span>
            <span>Log Out</span>
          </a>
        </div>
      </div>
      <div class="navbar-item dropdown has-divider has-user-avatar">
        <a class="navbar-link">
          <div class="user-avatar">
          <?php if (!empty($profilePicPath) && file_exists($profilePicPath)) : ?>
            <img src="<?php echo $profilePicPath; ?>" alt="Profile Picture" class="rounded-full">
          <?php endif; ?>
          </div>
          <div class="is-user-name"><span><?php echo isset($fetch_info['first_name']) ? $fetch_info['first_name'] : 'Home' ?></span></div>
          <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
        </a>
        <div class="navbar-dropdown">
          <a href="profile.html" class="navbar-item active">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span>My Profile</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-settings"></i></span>
            <span>Settings</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-email"></i></span>
            <span>Messages</span>
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item" href="logout-user.php">
            <span class="icon"><i class="mdi mdi-logout"></i></span>
            <span>Log Out</span>
          </a>
        </div>
      </div>
      <a title="Log out" class="navbar-item desktop-icon-only">
        <span class="icon"><i class="mdi mdi-logout"></i></span>
        <span>Log out</span>
      </a>
    </div>
  </div>
</nav>

<aside class="aside is-placed-left is-expanded">
  <div class="aside-tools">
    <div>
      <b class="font-black">EvLU</b>
    </div>
  </div>
  <div class="menu is-menu-main">
  <?php if ($isAdmin == 1): ?>
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <li>
        <a href="home.php">
          <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
          <span class="menu-item-label">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="pending.php">
          <span class="icon"><i class="mdi mdi-timetable"></i></span>
          <span class="menu-item-label">Pending Events</span>
        </a>
      </li>
      <li>
        <a href="reviews.php">
          <span class="icon"><i class="mdi mdi-star"></i></span>
          <span class="menu-item-label">Reviews</span>
        </a>
      </li>
      <li>
        <a href="add-events.php">
          <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
          <span class="menu-item-label">Add/Remove Events</span>
        </a>
      </li>
      <li>
        <a href="add-users.php">
          <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
          <span class="menu-item-label">Add/Remove User</span>
        </a>
      </li>
      <li>
        <a href="add-organizer.php">
          <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
          <span class="menu-item-label">Add/Remove Organizer</span>
        </a>
      </li>
      <?php endif; ?>
    </ul>
    <?php if ($isAdmin == 0): ?>
    <p class="menu-label">Examples</p>
    <ul class="menu-list">
      <li class="--set-active-tables-html">
        <a href="tables.php">
          <span class="icon"><i class="mdi mdi-table"></i></span>
          <span class="menu-item-label">Events</span>
        </a>
      </li>
      <li class="--set-active-forms-html">
        <a href="forms.php">
        <span class="icon"><i class="mdi mdi-star"></i></span>
          <span class="menu-item-label">Add Reviews</span>
        </a>
      </li>

      <!--
      <li>
        <a class="dropdown">
          <span class="icon"><i class="mdi mdi-view-list"></i></span>
          <span class="menu-item-label">Submenus</span>
          <span class="icon"><i class="mdi mdi-plus"></i></span>
        </a>
        <ul>
          <li>
            <a href="#void">
              <span>Sub-item One</span>
            </a>
          </li>
          <li>
            <a href="#void">
              <span>Sub-item Two</span>
            </a>
          </li>
        </ul>
      </li>
  -->
    </ul>
    <?php endif; ?>
    <p class="menu-label">About</p>
    <ul class="menu-list">
      <li class="active">
        <a href="profile.php">
          <span class="icon"><i class="mdi mdi-account-circle"></i></span>
          <span class="menu-item-label">Profile</span>
        </a>
      </li>
      <li>
        <a href="logout-user.php">
          <span class="icon"><i class="mdi mdi-logout"></i></span>
          <span class="menu-item-label">Logout</span>
        </a>
      </li>
    </ul>
    
  </div>
</aside>

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li><?php echo isset($fetch_info['first_name']) ? $fetch_info['first_name'] : 'Home' ?></li>
      <li>Profile</li>
    </ul>
  </div>
</section>

<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Profile
    </h1>
  </div>
</section>

  <section class="section main-section">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
            Edit Profile
          </p>
        </header>
        <div class="card-content">






















        <?php
$errors = [];
$successMessage = "";
$targetFilePath = "";

if (isset($_POST["update_picture"])) {
    $uploadedFileName = basename($_FILES["pp"]["name"]);
    $targetFilePath = "uploads/" . $uploadedFileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (!empty($uploadedFileName) && move_uploaded_file($_FILES["pp"]["tmp_name"], $targetFilePath)) {
        $servername = "localhost";
        $username = "jadchahine";
        $password = "jadali123";
        $dbname = "evlu";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $updateQuery = "UPDATE users SET profile_pic = '$targetFilePath' WHERE email = '$email'";
        echo "<meta http-equiv='refresh' content='0'>";

        if ($conn->query($updateQuery) === TRUE) {
            $successMessage = "Profile picture updated successfully.";
            $_SESSION['profile_pic'] = $targetFilePath;
        } else {
            $errors[] = "Error updating profile picture: " . $conn->error;
        }

        $conn->close();
    } else {
        $errors[] = "File upload failed.";
    }
}

if (isset($_POST["update_name"])) {
    $firstName = htmlspecialchars($_POST["first_name"]);
    $lastName = htmlspecialchars($_POST["last_name"]);

    if (empty($firstName) || empty($lastName)) {
        $errors[] = "There are missing fields.";
    }

    $servername = "localhost";
    $username = "jadchahine";
    $password = "jadali123";
    $dbname = "evlu";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $updateQuery = "UPDATE users SET first_name = '$firstName', last_name = '$lastName' WHERE email = '$email'";
    echo "<meta http-equiv='refresh' content='0'>";

    if ($conn->query($updateQuery) === TRUE) {
        $successMessage = "Name updated successfully.";
    } else {
        $errors[] = "Error updating name: " . $conn->error;
    }

    $conn->close();
}

if (isset($_POST["update_phone"])) {
    $phoneNumber = htmlspecialchars($_POST["phone_number"]);

    if (empty($phoneNumber)) {
        $errors[] = "Phone number is required.";
    }

    $servername = "localhost";
    $username = "jadchahine";
    $password = "jadali123";
    $dbname = "evlu";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $updateQuery = "UPDATE users SET phone_number = '$phoneNumber' WHERE email = '$email'";
    echo "<meta http-equiv='refresh' content='0'>";

    if ($conn->query($updateQuery) === TRUE) {
        $successMessage = "Phone number updated successfully.";
    } else {
        $errors[] = "Error updating phone number: " . $conn->error;
    }

    $conn->close();
}
?>

<form method="post" enctype="multipart/form-data">
<?php
    // Handle the form submission for updating profile picture
    if (isset($_POST["update_picture"])) {
        // Your validation and update logic here

        // Display success or error messages under the form
        if (!empty($successMessage) || !empty($errors)) {
            echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center">';
            echo $successMessage;
            echo '</div>';

            if (!empty($errors)) {
                echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center"><ul>';
                foreach ($errors as $error) {
                    echo '<li>' . $error . '</li>';
                }
                echo '</ul></div>';
            }
        }
    }
    ?>
    <div class="field">
        <label class="label">Profile Picture</label>
        <div class="field-body">
            <div class="field file">
                <input type="file" class="form-control" name="pp">
            </div>
        </div>
    </div>
    <button type="submit" class="button green" name="update_picture">
        Update
    </button>
</form>

<br>

<form method="post">
            <!-- Display success or error messages above the form -->
            <?php if (isset($successMessage)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center"><?php echo $successMessage; ?></div>
            <?php elseif (isset($errorMessage)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
    <div class="field">
        <label class="label">First Name</label>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <input type="text" autocomplete="on" name="first_name" value="" class="input" required>
                </div>
            </div>
        </div>
    </div>
    <div class="field">
        <label class="label">Last Name</label>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <input type="text" autocomplete="on" name="last_name" value="" class="input" required>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="button green" name="update_name">
        Update
    </button>
</form>
<hr>
                          <!-- Display success or error messages above the form -->
            <?php if (isset($successMessage)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center"><?php echo $successMessage; ?></div>
            <?php elseif (isset($errorMessage)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
  <form method="post">

    <div class="field">
        <label class="label">Phone Number</label>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <input type="text" autocomplete="on" name="phone_number" value="" class="input" required>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="button green" name="update_phone">
        Update
    </button>
</form>

        </div>
      </div>
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            Edit Profile
          </p>
        </header>
        <div class="card-content">
        <div class="image w-48 h-48 mx-auto">
        <div class="image w-48 h-48 mx-auto">
        <?php if (!empty($profilePicPath) && file_exists($profilePicPath)) : ?>
            <img src="<?php echo $profilePicPath; ?>" alt="Profile Picture" class="rounded-full">
        <?php else : ?>
            <p>No profile picture available</p>
        <?php endif; ?>
    </div>

</div>

          <hr>

          <div class="field">
            <label class="label">First Name</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $first_name; ?>" class="input is-static" name="first_name">
            </div>
          </div>
          
          <div class="field">
            <label class="label">Last Name</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $last_name; ?>" class="input is-static" name="last_name">
            </div>
          </div>

          <div class="field">
            <label class="label">Phone Number</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $phone_number; ?>" class="input is-static" name="phone_number">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-lock"></i></span>
          Change Password
        </p>
      </header>
      <div class="card-content">

      <?php
$errors = [];
$successMessage = "";

// Check if the form is submitted
if (isset($_POST['change_password'])) {
    // Get form data
    $currentPassword = htmlspecialchars($_POST["current_password"]);
    $newPassword = htmlspecialchars($_POST["new_password"]);
    $retypePassword = htmlspecialchars($_POST["retype_password"]);

    // Validate input data
    if (empty($currentPassword) || empty($newPassword) || empty($retypePassword)) {
        $errors[] = "All fields are required.";
    }

    $checkCurrentPasswordQuery = "SELECT password FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $checkCurrentPasswordQuery);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $storedPasswordHash = $row['password'];

        // Verify the current password
        if (password_verify($currentPassword, $storedPasswordHash)) {
            // Check if the new passwords match
            if ($newPassword !== $retypePassword) {
                $errors[] = "New passwords do not match.";
            } else {
                // Hash the new password
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $updateQuery = "UPDATE users SET password = '$hashedNewPassword' WHERE email = '$email'";

                if (mysqli_query($con, $updateQuery)) {
                    $successMessage = "Password changed successfully.";
                } else {
                    $errors[] = "Error updating password: " . mysqli_error($con);
                }
            }
        } else {
            $errors[] = "Current password is incorrect.";
        }
    } else {
        $errors[] = "Error checking current password. Please try again.";
    }
}

?>

<?php
    // Display success or error messages right under the form
    if (!empty($successMessage)) {
        echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center">' . $successMessage . '</div>';
    }

    if (!empty($errors)) {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center"><ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul></div>';
    }
    ?>

        <form method="post">
          <div class="field">
            <label class="label">Current password</label>
            <div class="control">
              <input type="password" name="current_password" autocomplete="current-password" class="input" required>
            </div>
            <p class="help">Required. Your current password</p>
          </div>
          <hr>
          <div class="field">
            <label class="label">New password</label>
            <div class="control">
              <input type="password" autocomplete="new-password" name="new_password" class="input" required>
            </div>
            <p class="help">Required. New password</p>
          </div>
          <div class="field">
            <label class="label">Confirm password</label>
            <div class="control">
              <input type="password" autocomplete="new-password" name="retype_password" class="input" required>
            </div>
            <p class="help">Required. New password one more time</p>
          </div>
          <hr>
          <div class="field">
            <div class="control">
              <button type="submit" class="button green" name="change_password">
                Submit
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>






  <footer class="footer">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
    <div class="flex items-center justify-start space-x-3">
      <div>
        © 2023, EvLU.org
      </div>
      <a href="https://github.com/justboil/admin-one-tailwind" style="height: 20px">
        <img src="https://img.shields.io/github/v/release/justboil/admin-one-tailwind?color=%23999">
      </a>
    </div>
    <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse font-poppins">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><path fill="blue" d="M32.25 6H29v2h3v22H4V8h3V6H3.75A1.78 1.78 0 0 0 2 7.81v22.38A1.78 1.78 0 0 0 3.75 32h28.5A1.78 1.78 0 0 0 34 30.19V7.81A1.78 1.78 0 0 0 32.25 6Z" class="clr-i-outline clr-i-outline-path-1"/><path fill="blue" d="M8 14h2v2H8z" class="clr-i-outline clr-i-outline-path-2"/><path fill="blue" d="M14 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-3"/><path fill="blue" d="M20 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-4"/><path fill="blue" d="M26 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-5"/><path fill="blue" d="M8 19h2v2H8z" class="clr-i-outline clr-i-outline-path-6"/><path fill="blue" d="M14 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-7"/><path fill="blue" d="M20 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-8"/><path fill="blue" d="M26 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-9"/><path fill="blue" d="M8 24h2v2H8z" class="clr-i-outline clr-i-outline-path-10"/><path fill="blue" d="M14 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-11"/><path fill="blue" d="M20 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-12"/><path fill="blue" d="M26 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-13"/><path fill="blue" d="M10 10a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" class="clr-i-outline clr-i-outline-path-14"/><path fill="blue" d="M26 10a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" class="clr-i-outline clr-i-outline-path-15"/><path fill="blue" d="M13 6h10v2H13z" class="clr-i-outline clr-i-outline-path-16"/><path fill="none" d="M0 0h36v36H0z"/></svg>
            <span class= "md:self-center text-2xl font-bold whitespace-nowrap  dark:text-white">EvLU</span>
        </a>
  </div>
</footer>

<div id="sample-modal" class="modal">
  <div class="modal-background --jb-modal-close"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Sample modal</p>
    </header>
    <section class="modal-card-body">
      <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
      <p>This is sample modal</p>
    </section>
    <footer class="modal-card-foot">
      <button class="button --jb-modal-close">Cancel</button>
      <button class="button red --jb-modal-close">Confirm</button>
    </footer>
  </div>
</div>

<div id="sample-modal-2" class="modal">
  <div class="modal-background --jb-modal-close"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Sample modal</p>
    </header>
    <section class="modal-card-body">
      <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
      <p>This is sample modal</p>
    </section>
    <footer class="modal-card-foot">
      <button class="button --jb-modal-close">Cancel</button>
      <button class="button blue --jb-modal-close">Confirm</button>
    </footer>
  </div>
</div>

</div>

<!-- Scripts below are for demo only -->
<script type="text/javascript" src="js/main.min.js?v=1628755089081"></script>


<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '658339141622648');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1"/></noscript>

<!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

<script>
  "use strict";

/* Aside & Navbar: dropdowns */
Array.from(document.getElementsByClassName('dropdown')).forEach(function (elA) {
  elA.addEventListener('click', function (e) {
    if (e.currentTarget.classList.contains('navbar-item')) {
      e.currentTarget.classList.toggle('active');
    } else {
      var dropdownIcon = e.currentTarget.getElementsByClassName('mdi')[1];
      e.currentTarget.parentNode.classList.toggle('active');
      dropdownIcon.classList.toggle('mdi-plus');
      dropdownIcon.classList.toggle('mdi-minus');
    }
  });
});
/* Aside Mobile toggle */

Array.from(document.getElementsByClassName('mobile-aside-button')).forEach(function (el) {
  el.addEventListener('click', function (e) {
    var dropdownIcon = e.currentTarget.getElementsByClassName('icon')[0].getElementsByClassName('mdi')[0];
    document.documentElement.classList.toggle('aside-mobile-expanded');
    dropdownIcon.classList.toggle('mdi-forwardburger');
    dropdownIcon.classList.toggle('mdi-backburger');
  });
});
/* NavBar menu mobile toggle */

Array.from(document.getElementsByClassName('--jb-navbar-menu-toggle')).forEach(function (el) {
  el.addEventListener('click', function (e) {
    var dropdownIcon = e.currentTarget.getElementsByClassName('icon')[0].getElementsByClassName('mdi')[0];
    document.getElementById(e.currentTarget.getAttribute('data-target')).classList.toggle('active');
    dropdownIcon.classList.toggle('mdi-dots-vertical');
    dropdownIcon.classList.toggle('mdi-close');
  });
});
/* Modal: open */

Array.from(document.getElementsByClassName('--jb-modal')).forEach(function (el) {
  el.addEventListener('click', function (e) {
    var modalTarget = e.currentTarget.getAttribute('data-target');
    document.getElementById(modalTarget).classList.add('active');
    document.documentElement.classList.add('clipped');
  });
});
/* Modal: close */

Array.from(document.getElementsByClassName('--jb-modal-close')).forEach(function (el) {
  el.addEventListener('click', function (e) {
    e.currentTarget.closest('.modal').classList.remove('active');
    document.documentElement.classList.remove('is-clipped');
  });
});
/* Notification dismiss */

Array.from(document.getElementsByClassName('--jb-notification-dismiss')).forEach(function (el) {
  el.addEventListener('click', function (e) {
    e.currentTarget.closest('.notification').classList.add('hidden');
  });
});
</script>
</body>
</html>
