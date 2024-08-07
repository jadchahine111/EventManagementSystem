<?php 
$con = mysqli_connect('localhost', 'jadchahine', 'jadali123');
if ($con) {
    mysqli_select_db($con, "evlu");
} else {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<?php 
require_once "controllerUserData.php"; 
?>
<?php 
$email = $_SESSION['email'];
$password = $_SESSION['password'];

if($email != false && $password != false){
    $sql = "SELECT * FROM organizers WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        $phone_number = $fetch_info['phone_number'];
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



<?php

if (isset($_GET['id'])) {
    $eventId = isset($_GET['id']) ? $_GET['id'] : null;

    $subscriptionSql = "SELECT Users.id, Users.first_name, Users.last_name, Users.email, Users.profile_pic
                        FROM Users
                        INNER JOIN Subscriptions ON Users.id = Subscriptions.user_id
                        WHERE Subscriptions.event_id = $eventId";
    $run_subscriptionSql = mysqli_query($con, $subscriptionSql);
    
    if ($run_subscriptionSql) {
        // Fetch the results into $resultAllSubUsers
        $resultAllSubUsers = $run_subscriptionSql;
    } 
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
    <div class="navbar-brand is-right">
      <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
        <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
      </a>
    </div>
    <div class="navbar-brand is-left">

      <?php
  function getGoBackLink() {
      $fallbackLink = 'organizer-pbevents.php'; // Fallback link if source is not provided or unexpected
      $source = isset($_GET['source']) ? $_GET['source'] : '';

      switch ($source) {
          //case 'tables':
          //    return 'tables.php';
          //case 'pending':
          //    return 'pending.php';
        //case 'home':
        //     return 'home.php';
          case 'organizer-archived.php':
            return 'organizer-archived.php';
          case 'organizer-pbevents.php':
              return 'organizer-pbevents.php';
          case 'organizer-pending.php':
              return 'organizer-pending.php';
          case 'views-event-org.php': // Add this case for 'views-event'
              return 'view-events-org.php';
          default:
              return $fallbackLink;
      }
  }
  ?>

      <a href="views-event-org.php?id=<?php echo $eventId; ?>&source=<?php echo getGoBackLink(); ?>" class="navbar-item">
          <span class="icon"><i class="mdi mdi-arrow-left mdi-24px"></i></span>
          <span>Go back</span>
      </a>
  </div>


    <div class="navbar-menu" id="navbar-menu">
      <div class="navbar-end">

        <div class="navbar-item dropdown has-divider has-user-avatar">
          <a class="navbar-link">
            <div class="user-avatar">
            <img src="<?php echo $profilePicPath; ?>" alt="Profile Picture" class="rounded-full">
            </div>
            <div class="is-user-name"><span><?php echo isset($fetch_info['organization_name']) ? $fetch_info['organization_name'] : 'Home' ?></span></div>
            <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
          </a>
          <div class="navbar-dropdown">


          <?php
              // Show these items for administrators
              echo '<a href="organizer-pbevents.php" class="navbar-item">';
              echo '<span class="icon"><i class="mdi mdi mdi-desktop-mac"></i></span>';
              echo '<span>Published Events</span>';
              echo '</a>';

              // Show these items for non-administrators
              echo '<a href="organizer-pending.php" class="navbar-item">';
              echo '<span class="icon"><i class="mdi mdi-settings"></i></span>';
              echo '<span>Pending Events</span>';
              echo '</a>';

              echo '<a href="organizer-archived.php" class="navbar-item">';
              echo '<span class="icon"><i class="mdi mdi-email"></i></span>';
              echo '<span>Archived Events</span>';
              echo '</a>';

          ?>
            <a href="profile.php" class="navbar-item">
              <span class="icon"><i class="mdi mdi-account"></i></span>
              <span>My Profile</span>
            </a>

            <hr class="navbar-divider">

          </div>
        </div>

        <a title="Log out" class="navbar-item desktop-icon-only" href="logout-user.php">
          <span class="icon"><i class="mdi mdi-logout"></i></span>
          <span>Log out</span>
        </a>
      </div>
    </div>
  </nav> 

  <section class="is-hero-bar">
  <div class="card has-table">
  <header class="card-header flex justify-between items-center">
        <div >
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            Subscribed Users
          </p>
        </div>
        <div>
          <input type="text" id="searchEventsInput" class="input" name="search2" style="height:50px;" placeholder="Search...">
        </div>
      </header>

    <div class="card-content">
        <table id="eventTable">
            <thead>
            <tr>
                    <th>ID</th>
                    <th>Profile Pic</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are rows in the result
                if ($resultAllSubUsers->num_rows > 0) {
                    // Loop through each row and print data in the table
                    while ($row = $resultAllSubUsers->fetch_assoc()) {
                        ?>
                        <tr>
                        <td data-label="ID"><?php echo $row['id']; ?></td>
                            <!-- Add other <td> elements for each column you have in the database -->
                            <td class="image-cell">
                                <div class="image">
                                    <img src="<?php echo $row['profile_pic']; ?>" class="rounded-full">
                                </div>
                            </td>
                              <td data-label="First Name"><?php echo $row['first_name']; ?></td>
                              <td data-label="Last Name"><?php echo $row['last_name']; ?></td>
                              <td data-label="Email"><?php echo $row['email']; ?></td>

                        </tr>
                    <?php
                    }
                } else {
                
            }
        ?>
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