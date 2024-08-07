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

    $subscriptionSql = "SELECT Users.id, Users.first_name, Users.last_name, Users.email
    FROM Users
    INNER JOIN Subscriptions ON Users.id = Subscriptions.user_id
    WHERE Subscriptions.event_id = $eventId AND Subscriptions.is_paid = 1";
    $run_subscriptionSql = mysqli_query($con, $subscriptionSql);

    if ($run_subscriptionSql) {
        // Fetch the results into $resultAllSubUsers
        $resultAllSubUsers = $run_subscriptionSql;
    }
}

if (isset($_GET['userid']) && isset($_GET['eventid']) && isset($_GET['actions']) && $_GET['actions'] === 'rejected') {
  $userId = $_GET['userid']; // Assuming $_GET['userid'] is the user ID
  $eventId = $_GET['eventid']; // Retrieve event ID from 'eventid' parameter
  $source = isset($_GET['source']) ? $_GET['source'] : '';

  // Fetch the current count of paid users for the event
  $getPaidUsersCountQuery = "SELECT payed_users FROM Events WHERE id = $eventId";
  $resultPaidUsersCount = mysqli_query($con, $getPaidUsersCountQuery);
  if (!$resultPaidUsersCount) {
      die("Error fetching paid users count: " . mysqli_error($con));
  }
  $rowPaidUsersCount = mysqli_fetch_assoc($resultPaidUsersCount);
  $currentPaidUsersCount = $rowPaidUsersCount['payed_users'];

  // Fetch the price of the event
  $getEventPriceQuery = "SELECT price FROM Events WHERE id = $eventId";
  $resultEventPrice = mysqli_query($con, $getEventPriceQuery);
  if (!$resultEventPrice) {
      die("Error fetching event price: " . mysqli_error($con));
  }
  $rowEventPrice = mysqli_fetch_assoc($resultEventPrice);
  $eventPrice = $rowEventPrice['price'];

  // Check if the current count is greater than 0 before decrementing
  if ($currentPaidUsersCount > 0) {
      // Update the paid users count in the Events table
      $updatePaidUsersCountQuery = "UPDATE Events SET payed_users = payed_users - 1 WHERE id = $eventId";
      $resultUpdatePaidUsersCount = mysqli_query($con, $updatePaidUsersCountQuery);

      if (!$resultUpdatePaidUsersCount) {
          die("Error updating paid users count: " . mysqli_error($con));
      }

      // Update the amount raised in the Events table by subtracting the event price
      $updateAmountRaisedQuery = "UPDATE Events SET amount_users = amount_users - $eventPrice WHERE id = $eventId";
      $resultUpdateAmountRaised = mysqli_query($con, $updateAmountRaisedQuery);

      if (!$resultUpdateAmountRaised) {
          die("Error updating amount raised: " . mysqli_error($con));
      }
  }

  // Update the subscription to set is_paid to 0
  $deleteQuery = "UPDATE Subscriptions SET is_paid = 0 WHERE user_id = $userId AND event_id = $eventId ";
  $reject = mysqli_query($con, $deleteQuery);

  if (!$reject) {
      die("Deletion Error: " . mysqli_error($con));
  }

      // Redirect to the desired URL
      header("Location: paid-subscribed-users.php?id=$eventId&source=$source");
      exit; // Ensure that subsequent code is not executed after the redirection
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

    <a href="views-event-org.php?id=<?php echo $eventId; ?>&source=<?php echo getGoBackLink()?>" class="navbar-item">
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





  <?php
// Check if the form is submitted
if (isset($_POST['payedSubmit'])) {
    // Get the user email from the form
    $userEmail = $_POST['payedEmail'];

    // Check if the user email is provided
    if ($userEmail !== null) {
        // Assuming $con is your database connection
        $con = mysqli_connect('localhost', 'jadchahine', 'jadali123');
        if ($con) {
            mysqli_select_db($con, "evlu");
        } else {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if the user exists
        $checkUserSql = "SELECT id FROM Users WHERE email = '$userEmail'";
        $resultCheckUser = mysqli_query($con, $checkUserSql);
        if (!$resultCheckUser) {
            die("SQL Error: " . mysqli_error($con));
        }

        if ($resultCheckUser && $resultCheckUser->num_rows > 0) {
          $eventId = isset($_GET['id']) ? $_GET['id'] : null; 

            $checkEventRegistrationSql = "SELECT is_paid FROM Subscriptions WHERE user_id IN (SELECT id FROM Users WHERE email = '$userEmail') AND event_id = $eventId";
            $resultCheckEventRegistration = mysqli_query($con, $checkEventRegistrationSql);

            if ($resultCheckEventRegistration && $row = mysqli_fetch_assoc($resultCheckEventRegistration)) {
                // Check if the user is already paid for the event
                if ($row['is_paid'] == 1) {
                    $errorMsg = "User has already paid for the event!";
                } else {
                    // Proceed with updating the Subscription and Events tables

                    // Your SQL query to update the Subscription table
                    $updateSubscriptionSql = "UPDATE Subscriptions SET is_paid = 1 WHERE user_id IN (SELECT id FROM Users WHERE email = '$userEmail')";
                    $resultUpdateSubscription = mysqli_query($con, $updateSubscriptionSql);

                    if ($resultUpdateSubscription) {
                        // Fetch event details
                        $getEventDetailsSql = "SELECT price FROM Events WHERE id = $eventId";
                        $resultGetEventDetails = mysqli_query($con, $getEventDetailsSql);

                        if ($resultGetEventDetails && $row = mysqli_fetch_assoc($resultGetEventDetails)) {
                            $price = $row['price'];

                            // Update Events table
                            $updateEventSql = "UPDATE Events SET amount_users = amount_users + $price, payed_users = payed_users + 1 WHERE id = $eventId";
                            $resultUpdateEvent = mysqli_query($con, $updateEventSql);

                            if ($resultUpdateEvent) {
                                // User added successfully
                                echo '<script>window.location.href = "paid-subscribed-users.php?id=' . $eventId . '&source=' . getGoBackLink() . '";</script>';
                              } else {
                                // Handle error updating Events table
                                $errorMsg = "Error updating Events table: " . mysqli_error($con);
                            }
                        } else {
                            // Handle error fetching event details
                            $errorMsg = "Error fetching event details: " . mysqli_error($con);
                        }
                    } else {
                        // Handle error updating Subscription table
                        $errorMsg = "Error updating Subscription table: " . mysqli_error($con);
                    }
                }
            } else {
                // The user is not registered for the event
                $errorMsg = "User is not registered for the event!";
            }
        } else {
            // The user does not exist
            $errorMsg = "User does not exist!";
        }
    } else {
        // Handle the case where the user email is not provided
        $errorMsg = "User email is required!";
    }
}

// Close the database connection
mysqli_close($con);
?>

<?php
if (!empty($successMsg)) {
    echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 mt-4 rounded text-center">' . $successMsg . '</div>';
}

if (!empty($errorMsg)) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 mt-4 rounded text-center">' . $errorMsg . '</div>';
}
?>


  <section class="my-8">
    <div class="card p-4">
        <h2 class="text-lg font-semibold mb-4">Add Payed Subscribed User</h2>
        <form method="POST" >
            <div class="flex items-center space-x-4">
                <input type="email"  class="input h-12 px-4 border rounded-md" name="payedEmail"
                    placeholder="Enter user email">
                <!-- You can add more input fields as needed -->
                <button type="submit"  name="payedSubmit" class="button px-6 green">Add User</button>
            </div>
        </form>
    </div>
</section>
  

          <br>
  <section class="is-hero-bar">
  <div class="card has-table">
  <header class="card-header flex justify-between items-center">
        <div >
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            Payed Subscribed Users
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
                if (isset($resultAllSubUsers) && $resultAllSubUsers->num_rows > 0) {
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
                              <td>
                                
                              <?php
                                    $source = isset($_GET['source']) ? $_GET['source'] : ''; // Store the source in a variable

                                    // Use the stored source variable when constructing the URL for the delete button
                                    ?>
                                                                  
                                <a href="paid-subscribed-users.php?userid=<?php echo $row['id']; ?>&eventid=<?php echo $eventId; ?>&source=<?php echo $source; ?>&actions=rejected" class="button small red">
                                        <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                                    </a>

                              </td>
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