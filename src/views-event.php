

<?php 
$con = mysqli_connect('localhost', 'jadchahine', 'jadali123');
if ($con) {
    mysqli_select_db($con, "evlu");
} else {
    die("Connection failed: " . mysqli_connect_error());
}

require_once "controllerUserData.php"; 

include("search-users.php");
$email = $_SESSION['email'];
$password = $_SESSION['password'];

if ($email != false && $password != false) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);

    if ($run_Sql) {
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        $isAdmin = $fetch_info['is_admin'];
        $profilePicPath = $fetch_info['profile_pic'];

        if ($status == "verified") {
            if ($code != 0) {
                header('Location: reset-code.php');
            }       
        } else {
            header('Location: user-otp.php');
        }
    }
} else {
    header('Location: login-user.php');
}
?>

<?php

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Fetch user information based on the provided ID
    $eventSql = "SELECT * FROM events WHERE id = $eventId";
    $run_EventSql = mysqli_query($con, $eventSql);

    if ($run_EventSql) {
        $eventInfo = mysqli_fetch_assoc($run_EventSql);

        // Extract user information
        $org_email = $eventInfo['organizer_email'];
        $event_name = $eventInfo['event_name'];
        $major_target = $eventInfo['major_target'];
        $description = $eventInfo['description'];
        $faculty = $eventInfo['faculty'];
        $location = $eventInfo['location'];
        $event_date_start = $eventInfo['event_date_start'];
        $event_date_finish = $eventInfo['event_date_finish'];
        $org_phone = $eventInfo['organizer_phone'];
        $price = $eventInfo['price'];
        $sub_users = $eventInfo['sub_users'];
        $amount_users = $eventInfo['amount_users'];
        $payed_users = $eventInfo['payed_users'];
        $is_verified = $eventInfo['is_verified'];

        // ... (add other fields)

    } else {
        // Handle query failure
        die("Query failed: " . mysqli_error($con));
    }
} else {
    exit();
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

  <body style="padding: 100px;">
  <div id="app">
    
 <nav style="padding:0px;" id="navbar-main" class="navbar is-fixed-top justify-end">
 <div class="navbar-brand">
    <a class="navbar-item mobile-aside-button">
      <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
    </a>

  </div>
 

    <div class="navbar-brand is-left">
    <?php
function getGoBackLink() {
    $fallbackLink = 'login-user.php'; // Fallback link if source is not provided or unexpected
    $source = isset($_GET['source']) ? $_GET['source'] : '';

    switch ($source) {
        case 'tables':
           return 'tables.php';
        case 'pending':
           return 'pending.php';
       case 'home':
            return 'home.php';
        case 'views-event': // Add this case for 'views-event'
            return 'view-events.php';
        default:
            return $fallbackLink;
    }
}
?>

    <a href="<?php echo getGoBackLink(); ?>" class="navbar-item">
        <span class="icon"><i class="mdi mdi-arrow-left mdi-24px"></i></span>
        <span>Go back</span>
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


        <?php
        if ($isAdmin == 1) {
            // Show these items for administrators
            echo '<a href="home.php" class="navbar-item">';
            echo '<span class="icon"><i class="mdi mdi mdi-desktop-mac"></i></span>';
            echo '<span>Dashboard</span>';
            echo '</a>';
        } else {
            // Show these items for non-administrators
            echo '<a href="tables.php" class="navbar-item">';
            echo '<span class="icon"><i class="mdi mdi-settings"></i></span>';
            echo '<span>Events</span>';
            echo '</a>';

            echo '<a href="subscribed-events.php" class="navbar-item">';
            echo '<span class="icon"><i class="mdi mdi-email"></i></span>';
            echo '<span>Subscribed Events</span>';
            echo '</a>';
        }
        ?>
          <a href="profile.php" class="navbar-item">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span>My Profile</span>
          </a>

          <hr class="navbar-divider">
          <a href="logout-user.php" class="navbar-item">
            <span class="icon"><i class="mdi mdi-logout"></i></span>
            <span>Log Out</span>
          </a>
        </div>
      </div>
      <a title="Log out" class="navbar-item desktop-icon-only" href="logout-user.php">
        <span class="icon"><i class="mdi mdi-logout"></i></span>
        <span>Log out</span>
      </a>
    </div>
  </div>
  </nav> 

  <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            Event Details
          </p>
        </header>
        <div class="card-content">

          <div class="field">
            <label class="label">Event Name</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $event_name; ?>" class="input is-static" name="first_name">
            </div>
          </div>
          
          <div class="field">
            <label class="label">Organized By</label>
            <div class="control">
              <input type="email" readonly value="<?php echo $org_email; ?>" class="input is-static" name="last_name">
            </div>
          </div>

          <div class="field">
            <label class="label">Description</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $description; ?>" class="input is-static" name="last_name">
            </div>
          </div>

          <div class="field">
            <label class="label">Major Target</label>
            <div class="control">
              <input type="email" readonly value="<?php echo $major_target; ?>" class="input is-static" name="last_name">
            </div>
          </div>

          <div class="field">
            <label class="label">in Faculty</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $faculty; ?>" class="input is-static" name="last_name">
            </div>
          </div>

          <div class="field">
            <label class="label">Location</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $location; ?>" class="input is-static" name="last_name">
            </div>
          </div>

          <div class="field">
            <label class="label">Start Date</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $event_date_start; ?>" class="input is-static" name="phone_number">
            </div>
          </div>

          <div class="field">
            <label class="label">End Date</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $event_date_finish; ?>" class="input is-static" name="phone_number">
            </div>
          </div>

          <div class="field">
            <label class="label">Organizer Phone</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $org_phone; ?>" class="input is-static" name="phone_number">
            </div>
          </div>

          <div class="field">
            <label class="label">Price</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $price; ?>" class="input is-static" name="phone_number">
            </div>
          </div>

          <div class="field">
            <label class="label">Nb. of Subscribed User</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $sub_users; ?>" class="input is-static" name="phone_number">
            </div>
          </div>

          <div class="field">
            <label class="label">Nb. of Payed Subscribed User</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $payed_users; ?>" class="input is-static" name="phone_number">
            </div>
          </div>

          <div class="field">
            <label class="label">Amount Raised</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $amount_users; ?>" class="input is-static" name="phone_number">
            </div>
          </div>

          <div class="field">
            <label class="label">Verified by Admin</label>
            <div class="control">
              <input type="text" readonly value="<?php echo ($is_verified == 1) ? 'Yes' : 'No'; ?>"  class="input is-static" name="phone_number">
            </div>
          </div>
          <hr>
          <?php if($isAdmin == 1): ?>
          <div class="flex space-x-4 justify-center">
    <a href="generate-statistics.php?id=<?php echo $eventId; ?>" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
        Generate Statistics
    </a>
</div>
<?php endif ?>


        </div>
      </div>





















  <!-- Scripts below are for demo only -->
  <script type="text/javascript" src="src/main.min.js?v=1628755089081"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
  <script type="text/javascript" src="js/chart.sample.min.js"></script>

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


  <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">



  <!--USER SEARCH AJAX JQUERY-->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
  $(document).ready(function () {
      $('#searchInputUsers').on('input', function () {
          var searchQuery = $(this).val();

          $.ajax({
              type: 'POST',
              url: 'search-users.php',
              data: { search: searchQuery },
              success: function (response) {
                  $('#userTable tbody').html(response);
              }
          });
      });
  });
  </script>


  <!--EVENT SEARCH AJAX JQUERY-->
  <script>
  $(document).ready(function () {
      $('#searchInputEvents').on('input', function () {
          var searchQuery = $(this).val();

          $.ajax({
              type: 'POST',
              url: 'search-events.php',
              data: { search: searchQuery },
              success: function (response) {
                  $('#eventTable tbody').html(response);
              }
          });
      });
  });
  </script>
  </body>
  </html>




