<?php
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

// Create a new connection for the second query
$con2 = mysqli_connect("localhost", "jadchahine", "jadali123");

if (!$con2) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select the database
$database_name = "evlu"; // Replace with your actual database name
if (!mysqli_select_db($con2, $database_name)) {
    die("Database selection failed: " . mysqli_error($con2));
}

// Fetch all users
$sql2 = "SELECT * FROM users";
$resultAllUsers = mysqli_query($con2, $sql2);
if (!$resultAllUsers) {
    die("Query failed: " . mysqli_error($con2));
}


// Fetch all events
$sql3 = "SELECT * FROM events";
$resultAllEvents = mysqli_query($con2, $sql3);
if (!$resultAllEvents) {
    die("Query failed: " . mysqli_error($con3));
}

// Fetch all unverified events
$sql3 = "SELECT * FROM events where is_verified = 0";
$resultAllUnverifiedEvents = mysqli_query($con2, $sql3);
if (!$resultAllUnverifiedEvents) {
    die("Query failed: " . mysqli_error($con3));
}

$sql2 = "SELECT * FROM events WHERE organizer_email = '$email'";
$resultAllPbEvents = mysqli_query($con2, $sql2);

if (!$resultAllPbEvents) {
    die("Query failed: " . mysqli_error($con2));
}

// Fetch all Unverified events
$sql3 = "SELECT * FROM events where is_verified = 0";
$resultAllUnverifiedEvents = mysqli_query($con2, $sql3);
if (!$resultAllUnverifiedEvents) {
    die("Query failed: " . mysqli_error($con3));
}

$sql2 = "SELECT * FROM events WHERE organizer_email = '$email'";
$resultAllPbEvents = mysqli_query($con2, $sql2);

if (!$resultAllPbEvents) {
    die("Query failed: " . mysqli_error($con2));
}

// Fetch total number of users
$sqlUserCount = "SELECT COUNT(*) as userCount FROM users";
$resultUserCount = mysqli_query($con2, $sqlUserCount);

if ($resultUserCount) {
    $userCount = mysqli_fetch_assoc($resultUserCount)['userCount'];
} else {
    $userCount = 0;
}

// Fetch total number of events
$sqlEventCount = "SELECT COUNT(*) as eventCount FROM events";
$resultEventCount = mysqli_query($con2, $sqlEventCount);

if ($resultEventCount) {
    $eventCount = mysqli_fetch_assoc($resultEventCount)['eventCount'];
} else {
    $eventCount = 0;
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
      <li class="active">
        <a>
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
    <p class="menu-label">Menu</p>
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
      <li>
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
      <!-- About
      <li>
        <a href="https://justboil.me/tailwind-admin-templates" class="has-icon">
          <span class="icon"><i class="mdi mdi-help-circle"></i></span>
          <span class="menu-item-label">About</span>
        </a>
      </li>
  -->
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
      <li>Pending Events</li>
    </ul>

  </div>
</section>

<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Pending Events
    </h1>
  </div>
</section>



  <section class="section main-section">


<!-- <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>
                Performance
              </h3>
              <h1>
                256%
              </h1>
            </div>
            <span class="icon widget-icon text-red-500"><i class="mdi mdi-finance mdi-48px"></i></span>
          </div>
        </div>
      </div>
  --> 


  <!-- CHARTS 
    <div class="card mb-6">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-finance"></i></span>
          Performance
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <div class="chart-area">
          <div class="h-full">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div></div>
              </div>
            </div>
            <canvas id="big-line-chart" width="2992" height="1000" class="chartjs-render-monitor block" style="height: 400px; width: 1197px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  -->   

  <?php
// pending.php

// Include your database connection script
require_once('connection.php');

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $row = []; // Initialize $row as an empty array

    if (isset($_GET['action']) && $_GET['action'] === 'accept') {
        // Update the database to mark the event as verified
        $update = mysqli_query($con2, "UPDATE events SET is_verified = 1 WHERE id = $event_id");

        if ($update) {
            // Fetch event details from the database
            $result = mysqli_query($con2, "SELECT * FROM events WHERE id = $event_id");
            $row = mysqli_fetch_assoc($result);

            $organizer_email = $row['organizer_email'];
            // Send email to the organizer about event acceptance
            $to = $organizer_email;
            $subject = "Event Accepted";
            $message = "Dear Organizer,\n\nYour event has been accepted by the administrator.\n\nEvent Details:\n";
            $message .= "Event Name: " . $row['event_name'] . "\n";
            $headers = "From: jadalichahine@gmail.com";
            mail($to, $subject, $message, $headers);
            echo '<script>window.location.href = "pending.php";</script>';
            die();
        } else {
            // Handle the case where the update query fails
            echo "Error updating event status.";
        }
    } elseif (isset($_GET['action']) && $_GET['action'] === 'reject') {
        // Fetch organizer's email from the database before deletion
        $result = mysqli_query($con2, "SELECT organizer_email, event_name, event_date_start FROM events WHERE id = $event_id");
        $row = mysqli_fetch_assoc($result);

        // Delete the event from the database
        $delete = mysqli_query($con2, "DELETE FROM events WHERE id = $event_id");

        if ($delete) {
            $organizer_email = $row['organizer_email'];
            // Send email to the organizer about event rejection
            $to = $organizer_email;
            $subject = "Event Rejected";
            $message = "Dear Organizer,\n\nUnfortunately, your event " . $row['event_name'] . " has been rejected by the administrator.\n\nEvent Details:\n";
            $message .= "Event Name: " . $row['event_name'] . "\n";
            $message .= "Start Date: " . $row['event_date_start'] . "\n";
            $headers = "From: jadalichahine@gmail.com";
            mail($to, $subject, $message, $headers);
            echo '<script>window.location.href = "pending.php";</script>';
            die();
        } else {
            // Handle the case where the delete query fails
            echo "Error deleting event.";
        }
    }
}

// Handle other cases or show an error page
?>







    <div class="card has-table">
      <header class="card-header flex justify-between items-center">
        <div >
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-calendar-outline"></i></span>
            Pending Events
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
                <th>Org.Email</th>
                <th>Name</th>
                <th>Major Target</th>
                <th>Description</th>
                <th>Faculty</th>
                <th>Location</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Organizer_Phone</th>
                <th>Price</th>
                <th>is_ended</th>
                <th>Sub Users</th>
                <th>Payed-Sub Users</th>
                <th>Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are rows in the result
            if ($resultAllUnverifiedEvents->num_rows > 0) {
                // Loop through each row and print data in the table
                while ($row = $resultAllUnverifiedEvents->fetch_assoc()) {
                    ?>
                    <tr>
                        <td data-label="ID"><?php echo $row['organizer_email']; ?></td>
                        <td data-label="ID"><?php echo $row['event_name']; ?></td>
                        <td data-label="ID"><?php echo $row['major_target']; ?></td>
                        <td data-label="ID"><?php echo $row['description']; ?></td>
                        <td data-label="ID"><?php echo $row['faculty']; ?></td>
                        <td data-label="ID"><?php echo $row['location']; ?></td>
                        <td data-label="ID"><?php echo $row['event_date_start']; ?></td>
                        <td data-label="ID"><?php echo $row['event_date_finish']; ?></td>
                        <td data-label="ID"><?php echo $row['organizer_phone']; ?></td>
                        <td data-label="ID"><?php echo $row['price']; ?></td>
                        <td data-label="ID"><?php echo ($row['is_ended'] == '1') ? 'Yes' : 'No'; ?></td>
                        <td data-label="ID"><?php echo $row['sub_users']; ?></td>
                        <td data-label="ID"><?php echo $row['amount_users']; ?></td>
                        <td data-label="ID"><?php echo $row['payed_users']; ?></td>
                        <!-- Add other <td> elements for each column you have in the database -->
                        <td class="actions-cell">
                            <div class="buttons right nowrap">
                                <a href="views-event.php?id=<?php echo $row['id']; ?>&source=pending" class="button small blue --jb-modal" data-target="sample-modal-2">
                                    <span class="icon"><i class="mdi mdi-eye"></i></span>
                                </a>
                                <a href="pending.php?id=<?php echo $row['id']; ?>&action=accept" class="button small green">
                                    <span class="icon"><i class="mdi mdi-check"></i></span>
                                </a>
                                <a href="pending.php?id=<?php echo $row['id']; ?>&action=reject" class="button small red">
                                    <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php
                }
            } else {
            // No events found
            ?>
            </tbody>
        </table>
        <div class="card empty">
            <div class="card-content">
                <div>
                    <span class="icon large"><i class="mdi mdi-emoticon-sad mdi-48px"></i></span>
                </div>
                <p>Nothing's here…</p>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>


</div>
  </section>




<!--div id="sample-modal" class="modal">
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

  -->




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
