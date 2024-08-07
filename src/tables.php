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
        $user_id = $fetch_info['id'];
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

// Fetch all events that have ended
$currentDate = date('Y-m-d H:i:s');  // Get the current date and time
$updateSql = "UPDATE events SET is_ended = 1 WHERE event_date_finish <= NOW() AND is_ended = 0 AND organizer_email = '$email'";
$updateResult = mysqli_query($con2, $updateSql);

if (!$updateResult) {
    die("Update failed: " . mysqli_error($con2));
}
// Fetch all events
$sql3 = "SELECT * FROM events WHERE is_verified = 1 and is_ended = 0 and event_date_finish >= NOW()";
$resultAllPbEvents = mysqli_query($con2, $sql3);
if (!$resultAllPbEvents) {
    die("Query failed: " . mysqli_error($con2));
}

?>

<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tables</title>

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
      <div class="navbar-item dropdown has-divider">
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
      <li class="active">
        <a>
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



<?php
                    $successMessage = $errorMessage = "";

                    if (isset($_POST['subscribe_event'])) {
                        // Retrieve user and event information
                        $user_id = $fetch_info['id']; // Assuming you have the user ID in $fetch_info
                        $event_id = $_POST['event_id'];
                    
                        // Check if the user is already subscribed to the event
                        $checkSubscriptionSql = "SELECT * FROM Subscriptions WHERE user_id = $user_id AND event_id = $event_id";
                        $checkSubscriptionResult = mysqli_query($con2, $checkSubscriptionSql);
                    
                        if ($checkSubscriptionResult->num_rows == 0) {
                            // User is not subscribed, insert a new subscription
                            $insertSubscriptionSql = "INSERT INTO Subscriptions (user_id, event_id) VALUES ($user_id, $event_id)";
                            $insertSubscriptionResult = mysqli_query($con2, $insertSubscriptionSql);
                    
                            if ($insertSubscriptionResult) {
                              // Increment the subscribed user count for the event
                              $updateEventSubscriptionCountSql = "UPDATE events SET sub_users = sub_users + 1 WHERE id = $event_id";
                              $updateEventSubscriptionCountResult = mysqli_query($con2, $updateEventSubscriptionCountSql);
                  
                              if ($updateEventSubscriptionCountResult) {
                                  $successMessage = "Subscription successful!";
                              } else {
                                  $errorMessage = "Error updating event subscription count: " . mysqli_error($con2);
                              }
                          } else {
                              $errorMessage = "Error subscribing to the event: " . mysqli_error($con2);
                          }
                      } else {
                          $errorMessage = "You are already subscribed to this event.";
                      }
                    }
                    ?>
<?php
if (!empty($successMessage)) {
    echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center">' . $successMessage . '</div>';
}

if (!empty($errorMessage)) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center">' . $errorMessage . '</div>';
}
?>


<section class="section main-section">
    <div class="card-container">
        <?php
        // Check if there are rows in the result
        if ($resultAllPbEvents->num_rows > 0) {
            // Loop through each row and print data in the cards
            while ($row = $resultAllPbEvents->fetch_assoc()) {

              $eventId = $row['id'];
        // Check if the user is already subscribed to the event
        $checkSubscriptionSql = "SELECT * FROM Subscriptions WHERE user_id = $user_id AND event_id = $eventId";
        $checkSubscriptionResult = mysqli_query($con2, $checkSubscriptionSql);

        $isSubscribed = $checkSubscriptionResult->num_rows > 0;
                ?>
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
                            <?php echo $row['event_name']; ?>
                        </p>
                    </header>
                    <div class="card-content">
                        <div>
                            <!-- Add other elements for each property you want to display -->
                            <div class="property-group">
                                <p><strong>Organized By:</strong> <?php echo $row['organizer_email']; ?></p>
                                <p><strong>Organizer Phone:</strong> <?php echo $row['organizer_phone']; ?></p>
                            <br>
                            <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                            <br>
                            <div class="property-group">
                                <p><strong>Target Major:</strong> <?php echo $row['major_target']; ?></p>
                                <p><strong>Faculty:</strong> <?php echo $row['faculty']; ?></p>
                            </div>
                            <br>
                            <div class="property-group">
                                <p><strong>Start Date:</strong> <?php echo $row['event_date_start']; ?></p>
                                <p><strong>End Date:</strong> <?php echo $row['event_date_finish']; ?></p>
                            </div>

                            <br>
                            
                            <!-- Add other properties as needed -->
                        </div>
                    </div>
                    <div class="flex space-x-4 justify-start gap-2">
                    <a href="views-event.php?id=<?php echo $row['id']; ?>&source=tables" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                      View Event
                    </a>










                    <form method="post"> <!-- Assuming subscribe-event.php is the file that handles subscriptions -->
                        <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>"> <!-- Include the event ID as a hidden input field -->
                        <button type="submit" name="subscribe_event" class="bg-<?php echo $isSubscribed ? 'gray-500' : 'blue-500'; ?> <?php echo $isSubscribed ? '' : 'hover:bg-blue-700'; ?> text-white font-bold py-2 px-4 rounded" <?php echo $isSubscribed ? 'disabled' : ''; ?>>
    <?php echo $isSubscribed ? 'Subscribed' : 'Subscribe'; ?>
</button>
                    </form>
                    </div>
                </div>
                <?php
            }
        } else {
            // No events found
            ?>
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
</section>






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
