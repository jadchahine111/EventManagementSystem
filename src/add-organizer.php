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
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        $isAdmin = $fetch_info['is_admin'];
        $profilePicPath = $fetch_info['profile_pic'];
        
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
  <title>Dashboard</title>

  <!-- Tailwind is included -->
  <link rel="stylesheet" href="css/main.css?v=1628755089081">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

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
    <script>
        function scrollToTop() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
        }
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
          <a href="profile.php" class="navbar-item">
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
          <a class="navbar-item">
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
      <li >
        <a href="add-users.php">
          <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
          <span class="menu-item-label">Add/Remove User</span>
        </a>
      </li>
      <li class="active">
        <a>
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

      <li class="--set-active-profile-html">
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
      <li><?php echo isset($fetch_info['first_name']) ? $fetch_info['first_name'] : 'Home' ?></</li>
      <li>Add or Remove Organizer</li>
    </ul>

  </div>
</section>

<section class="is-hero-bar">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
      <h1 class="title">
        Add or Remove Organizer
      </h1>
    </div>
</section>



<section class="section main-section">
    <div class="card mb-6">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-ballot"></i></span>
          Add Organizer
        </p>
    </header>







































    <div class="card-content">
    <?php

// Initialize variables for error and success messages
$errors = [];
$successMessage = "";

// Check if the form is submitted
if (isset($_POST["add_user"])) {
    // Validate and sanitize input data
    $organization_type = htmlspecialchars($_POST["organization_type"]);
    $organization_name = htmlspecialchars($_POST["organization_name"]);
    $email1 = htmlspecialchars($_POST["email1"]);
    $phone_number = htmlspecialchars($_POST["phone_number"]);
    $password = htmlspecialchars($_POST["password"]);

    // Validate input data (add more validation as needed)
    if (empty($organization_type) || empty($organization_name) || empty($email1) || empty($phone_number) || empty($password) || empty($_POST["retype_password"])) {
        $errors[] = "There are missing fields.";
    }

    // Validate password match
    if ($_POST["password"] !== $_POST["retype_password"]) {
        $errors[] = "Password and Retype Password do not match.";
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Database connection (replace with your connection code)
    $servername = "localhost";
    $username = "jadchahine";
    $password = "jadali123";
    $dbname = "evlu";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email already exists in the database
    $emailCheckQuery = "SELECT email FROM organizers WHERE email = '$email1'
                        UNION
                        SELECT email FROM users WHERE email = '$email1'";
    $emailCheckResult = $conn->query($emailCheckQuery);

// Check if the query was successful
if ($emailCheckResult === false) {
  $errors[] = "Error checking email: " . $conn->error;
} else {
  // Check if the email already exists
  if ($emailCheckResult->num_rows > 0) {
      $errors[] = "Email already used!";
  } else {
      // If there are no errors, proceed with inserting into the database
      if (empty($errors)) {
          // SQL query to insert user data into the 'organizers' table
          $sql = "INSERT INTO organizers (organizer_type, organization_name, phone_number, email, password, code, is_verified, status)
                  VALUES ('$organization_type', '$organization_name', '$phone_number', '$email1', '$hashedPassword', 0, 1, 'unverified')";

          if ($conn->query($sql) === TRUE) {
              // User added successfully, send email
              $subject = "Welcome to EvLU!";
              $message = "Dear $organization_name,\n\nYour Organizer account has been created successfully by the administrator.\n\nEmail: $email1\nPassword: {$_POST['password']}\n\nThank you!";
              $headers = "From: jadalichahine@gmail.com";

              mail($email1, $subject, $message, $headers);

              $successMessage = "Organizer added successfully. An email has been sent to $email1 with login details.";
          } else {
              $errors[] = "Error: " . $sql . "<br>" . $conn->error;
          }
      }
  }
}

    $conn->close();
}

// Reset variables for add user form
$success_message = "";
$error_message = "";

?>

<?php
// Initialize variables for success and error messages
$success_message1 = "";
$error_message1 = "";

// Check if the form is submitted
if (isset($_POST["org_email1"])) {
    // Get user email from the form
    $org_email1 = trim($_POST["org_email1"]);

    // Validate user email
    if (empty($org_email1)) {
        $error_message1 .= "Organizer email is required.<br>";
    } elseif (!filter_var($org_email1, FILTER_VALIDATE_EMAIL)) {
        $error_message1 .= "Invalid email format.<br>";
    } else {
        // Database connection (replace with your connection code)
        $servername = "localhost";
        $username = "jadchahine";
        $password = "jadali123";
        $dbname = "evlu";
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the email exists in the database
        $check_query = "SELECT * FROM organizers WHERE email = '$org_email1'";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            // Email found, proceed with deletion
            // Check for related records and delete them
            $organizer_id = $result->fetch_assoc()['id'];
            
            // Delete related records from the Reviews table
            $delete_reviews_query = "DELETE FROM Reviews WHERE organizer_id = '$organizer_id'";
            if ($conn->query($delete_reviews_query) === FALSE) {
                $error_message1 .= "Error deleting reviews: " . $conn->error . "<br>";
            }

            // Delete pending events associated with the organizer
            $delete_events_query = "DELETE FROM Events WHERE organizer_email = '$org_email1' AND is_verified = 0";
            if ($conn->query($delete_events_query) === FALSE) {
                $error_message1 .= "Error deleting pending events: " . $conn->error . "<br>";
            }

            // Update Events table to replace organizer_email with "Deleted Organizer"
            $update_events_query = "UPDATE Events SET organizer_email = 'Deleted Organizer' WHERE organizer_email = '$org_email1'";
            if ($conn->query($update_events_query) === FALSE) {
                $error_message1 .= "Error updating Events: " . $conn->error . "<br>";
            }

            // Finally, delete the organizer
            $delete_query = "DELETE FROM organizers WHERE email = '$org_email1'";
            if ($conn->query($delete_query) === TRUE) {
                $success_message1 = "Organizer with email '$org_email1' has been deleted successfully.";
            } else {
                $error_message1 .= "Error deleting organizer: " . $conn->error . "<br>";
            }
        } else {
            $error_message1 = "Organizer with email '$org_email1' not found in the database.";
        }

        $conn->close();
    }
}
?>

<!-- Display success or error messages at the top of the form -->
<?php if (!empty($successMessage) || !empty($errors)) : ?>
    <script>
        // Call the scrollToTop function to scroll the page to the top
        scrollToTop();
    </script>

    <?php if (!empty($successMessage)) : ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<?php endif; ?>

 <!-- Display success or error messages at the top of the form -->
 <?php if (!empty($success_message1) || !empty($error_message1)) : ?>
    <?php if (!empty($success_message1)) : ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center"><?php echo $success_message1; ?></div>
    <?php endif; ?>

    <?php if (!empty($error_message1)) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center">
            <ul>
                <li><?php echo $error_message1; ?></li>
            </ul>
        </div>
    <?php endif; ?>
<?php endif; ?>


        
        
        <form method="post">
        <div class="field">
                <label class="label">Organization Type</label>
                <div class="control">
                  <div class="select">
                    <select name="organization_type" value="<?php echo isset($faculty) ? $faculty : ''; ?>">
                      <option>Individual</option>
                      <option>Organization</option>
                    </select>
                  </div>
                </div>
        </div>

        <div class="field">
                    <label class="label">Organization Name</label>
                    <div class="field-body">
                      <div class="field">
                        <div class="control">
                          <input class="input" type="text" placeholder="Organization name" name="organization_name" value="<?php echo isset($file_no) ? $file_no : ''; ?>">
                        </div>
                      </div>
                    </div>
        </div>

        <div class="field">
                  <label class="label">Phone Number</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <input class="input" type="number" placeholder="Phone Number" name="phone_number" value="<?php echo isset($phone_number) ? $phone_number : ''; ?>" required>
                      </div>
                      
                    </div>
                  </div>
              </div>


                <div class="field">
                    <label class="label">Email</label>
                    <div class="field-body">
                      <div class="field">
                        <div class="control">
                          <input class="input" type="email" placeholder="Email" name="email1" value="<?php echo isset($email1) ? $email1 : ''; ?>" required>
                        </div>
                        <p class="help">Example: john.doe@gmail.com</p>
                      </div>
                    </div>
                </div>

            <div class="field">
                <label class="label">Password</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input class="input" type="password" placeholder="Password" name="password">
                    </div>
                  </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Retype Password</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input class="input" type="password" placeholder="Retype Password" name="retype_password">
                    </div>
                  </div>
                </div>
            </div>

 
            <hr>
  
            <div class="field grouped">
              <div class="control">
                <button type="submit" name="add_user" class="button green">
                  Add Organizer
                </button>
              </div>
              <div class="control">
                <button type="reset" class="button red">
                  Reset
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>































      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-ballot-outline"></i></span>
            Delete Organizer
          </p>
        </header>
        <div class="card-content">





            <form method="post">
                <div class="field">
                  <label class="label">Organizer email</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control icons-left">
                        <input class="input" type="email" placeholder="Organizer email" name="org_email1">
                        <span class="icon left"><i class="mdi mdi-account"></i></span>
                      </div>
                    </div>
                    <hr>
  
                    <div class="field grouped">
                      <div class="control">
                        <button type="submit" class="button green">
                          Delete Organizer
                        </button>
                      </div>
                      <div class="control">
                        <button type="reset" class="button red">
                          Reset
                        </button>
                      </div>
                    </div>
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
            <span class= "md:self-center text-2xl font-bold whitespace-nowrap  dark:text-white" >EvLU</span>
        </a>
  </div>
</footer>



















    <script>"use strict";

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
});</script>



</body>
<!-- Scripts below are for demo only -->
<script type="text/javascript" src="js/main.min.js?v=1628755089081"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script type="text/javascript" src="js/chart.sample.min.js"></script>


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

</html>