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
      <li class="active">
        <a>
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
      <li><?php echo isset($fetch_info['first_name']) ? $fetch_info['first_name'] : 'Home' ?></li>
      <li>Add or Remove Events</li>
    </ul>

  </div>
</section>

<section class="is-hero-bar">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
      <h1 class="title">
        Add or Remove Events
      </h1>
    </div>
</section>

<section class="section main-section">
    <div class="card mb-6">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-ballot"></i></span>
          Add Event
        </p>
    </header>
    <div class="card-content">


    <?php
// Assuming your database connection is established

// Your form submission handling
if (isset($_POST['add-event'])) {
    // Retrieve form data
    $eventName = $_POST['event_name']; // Replace 'event_name' with the actual name attribute of your input
    $majorTarget = $_POST['target_majors']; // Replace 'target_majors' with the actual name attribute of your select
    $description = $_POST['description']; // Replace 'description' with the actual name attribute of your textarea
    $faculty = $_POST['faculty']; // Replace 'faculty' with the actual name attribute of your select
    $location = $_POST['location']; 
    $startDateTime = $_POST['start_date']; 
    $endDateTime = $_POST['end_date']; 
    $price = $_POST['price']; 
    $email = $_POST['organized_by']; // Add this line to retrieve the organizer's email

    // Initialize error and success messages
    $errors = [];
    $successMessage = "";

    // Perform validation
    if (empty($eventName)) {
        $errors[] = "Event Name is required.";
    }

    if (empty($majorTarget)) {
        $errors[] = "Major Target is required.";
    }

    if (empty($description)) {
        $errors[] = "Description is required.";
    }

    if (empty($faculty)) {
        $errors[] = "Faculty is required.";
    }

    if (empty($location)) {
        $errors[] = "Location is required.";
    }

    if (strtotime($startDateTime) > strtotime($endDateTime)) {
        $errors[] = "Start date time must be before end date time.";
    }
    
    if (empty($price)) {
        $errors[] = "Price is required.";
    }

    // Check if the organizer email exists in the organizers table
    $checkOrganizerQuery = "SELECT * FROM organizers WHERE email = '$email'";
    $checkOrganizerResult = mysqli_query($con, $checkOrganizerQuery);

    if (!$checkOrganizerResult || mysqli_num_rows($checkOrganizerResult) === 0) {
        $errors[] = "The email '$email' is not associated with an organizer account.";
    }

    // If there are no errors, proceed to add the event
    if (empty($errors)) {
        // Retrieve organizer's phone number based on the provided email
        $organizerPhoneQuery = "SELECT phone_number FROM organizers WHERE email = '$email'";
        $organizerPhoneResult = mysqli_query($con, $organizerPhoneQuery);

        if ($organizerPhoneResult && mysqli_num_rows($organizerPhoneResult) > 0) {
            $organizerData = mysqli_fetch_assoc($organizerPhoneResult);
            $phone_number = $organizerData['phone_number'];

            // Perform the database query to add the event
            $sql = "INSERT INTO events (event_name, major_target, description, faculty, location, event_date_start, event_date_finish, organizer_phone, price, organizer_email, is_ended, sub_users, amount_users, payed_users, is_verified) 
            VALUES ('$eventName', '$majorTarget', '$description', '$faculty', '$location', '$startDateTime', '$endDateTime', '$phone_number', '$price', '$email', 0, 0, 0, 0, 1)";        

            $result = mysqli_query($con, $sql);

            if ($result) {
                $successMessage = "Event added successfully!";

                // Send email to the organizer
                $to = $email; // Organizer's email
                $subject = "Your Event has been approved";
                $message = "Dear Organizer,\n\nYour requested event '$eventName' has been approved by the administrator. Here are the details:\n\nEvent Name: $eventName\nDescription: $description\nMajor Target: $majorTarget\nFaculty: $faculty\nLocation: $location\nStart Date: $startDateTime\nEnd Date: $endDateTime\nPrice: $price\n\nThank you for using our platform!";
                $headers = "From: your_email@example.com"; // Change this to your website's email

                if (mail($to, $subject, $message, $headers)) {
                    $successMessage .= " An email has been sent to $email with all the details.";
                } else {
                    $errorMessage = "Error sending email. Please try again.";
                }
            } else {
                $errorMessage = "Error: " . mysqli_error($con);
            }
        } else {
            $errorMessage = "Error retrieving organizer's phone number.";
        }
    } else {
        $errorMessage = implode("<br>", $errors);
    }
}
?>








<!-- Your HTML form goes here -->

        <!-- Display success or error messages -->
        <?php if (!empty($successMessage)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center"><?= $successMessage ?></div>
        <?php elseif (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post">

            <div class="field">
              <label class="label">Event Name</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input class="input" type="text" placeholder="Name" name="event_name">
                  </div>
                </div>
              </div>
            </div>

            <div class="field">
              <label class="label">Organized By</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input class="input" type="email" placeholder="Email" name="organized_by">
                  </div>
                  <p class="help">Use organizer email</p>
                </div>
              </div>
            </div>

            <div class="field">
                <label class="label">Description</label>
                <div class="control">
                  <textarea class="textarea" placeholder="About this Event..." name="description"></textarea>
                </div>
            </div>



            <div class="field">
                <label class="label">Target Major</label>
                <div class="control">
                  <div class="select">
                    <select name="target_majors">
                      <option>Business development</option>
                      <option>Marketing</option>
                      <option>Development</option>
                    </select>
                  </div>
                </div>
            </div>


            <hr>
            
            <div class="field">
                <label class="label">Faculty</label>
                <div class="control">
                  <div class="select" name="faculty">
                    <select name="faculty">
                      <option>Business development</option>
                      <option>Marketing</option>
                      <option>Sales</option>
                    </select>
                  </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Location</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input class="input" type="text" placeholder="Location" name="location">
                    </div>
                  </div>
                </div>
              </div>
              
              <hr>

              <div class="field">
                <label class="label">Date and Time (start)</label>
                <div class="field-body">
                    <div class="field">
                    <div class="control">
                    <input class="input" type="datetime-local" id="datetimepicker" name="start_date">
                </div>
                </div>
            </div>
            </div>

            <div class="field">
                <label class="label">Date and Time (end)</label>
                <div class="field-body">
                    <div class="field">
                    <div class="control">
                    <input class="input" type="datetime-local" id="datetimepicker" name="end_date">
                </div>
                </div>
            </div>
            </div>


              <hr> 

            

          <div class="field">
              <label class="label">Price</label>
            <div class="field-body">
              <div class="field">
                <div class="field addons">
                  <div class="control">
                    <input class="input" value="$" size="3" readonly>
                  </div>
                  <div class="control expanded">
                    <input class="input" type="number" placeholder="Price" name="price">
                  </div>
                </div>  
              </div>
            </div>
          </div>

            <hr>
  
            <div class="field grouped">
              <div class="control">
                <button type="submit" class="button green" name="add-event">
                  Add Event
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


      <?php
// Initialize variables for success and error messages
$successMessage = "";
$errorMessage = "";

// Check if the form is submitted
if (isset($_POST["delete-event"])) {
    // Get event name from the form
    $eventName = isset($_POST["Event_Name"]) ? trim($_POST["Event_Name"]) : '';

    // Validate event name
    if (empty($eventName)) {
        $errorMessage .= "Event name is required.<br>";
    } else {
        // Database connection (replace with your connection code)
        $dbServername = "localhost";
        $dbUsername = "jadchahine";
        $dbPassword = "jadali123";
        $dbName = "evlu";
        $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the event exists in the database
        $checkQuery = "SELECT * FROM events WHERE event_name = '$eventName'";
        $result = $conn->query($checkQuery);

        if ($result->num_rows > 0) {
            // Event found, proceed with deletion
            // SQL query to delete event by name
            $deleteQuery = "DELETE FROM events WHERE event_name = '$eventName'";

            if ($conn->query($deleteQuery) === TRUE) {
                $successMessage = "Event '$eventName' has been deleted successfully.";
            } else {
                $errorMessage = "Error deleting event: " . $conn->error;
            }
        } else {
            $errorMessage = "Event '$eventName' not found in the database.";
        }

        $conn->close();
    }
}
?>

      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-ballot-outline"></i></span>
            Delete Event
          </p>
        </header>
        <div class="card-content">
        <?php if (!empty($successMessage) || !empty($errorMessage)) : ?>
            <?php if (!empty($successMessage)) : ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (!empty($errorMessage)) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center">
                    <ul>
                        <li><?php echo $errorMessage; ?></li>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
            <form method="post">
                <div class="field">
                  <label class="label">Event name</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control icons-left">
                        <input class="input" type="text" placeholder="Event name" name="Event Name">
                        <span class="icon left"><i class="mdi mdi-account"></i></span>
                      </div>
                    </div>
                    <hr>
  
                    <div class="field grouped">
                      <div class="control">
                        <button type="submit" class="button green" name="delete-event">
                          Delete Event
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
            <span class= "md:self-center text-2xl font-bold whitespace-nowrap  dark:text-white">EvLU</span>
        </a>
  </div>
</footer>








































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

</html>