  <?php
  require_once "controllerUserData.php"; 

  include("search-users.php");
  $email = $_SESSION['email'];
  $password = $_SESSION['password'];

  if ($email != false && $password != false) {
      $sql = "SELECT * FROM organizers WHERE email = '$email'";
      $run_Sql = mysqli_query($con, $sql);

      if ($run_Sql) {
          $fetch_info = mysqli_fetch_assoc($run_Sql);
          $status = $fetch_info['status'];
          $organizer_id = $fetch_info['id'];
          $code = $fetch_info['code'];
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

  // Fetch total subscribed users of the organizer's events
  $sqlTotalSubCount = "
  SELECT IFNULL(SUM(sub_users), 0) AS total_subscribed_users
  FROM Events
  WHERE organizer_email = '$email'
";

  $resultTotalSubCount = mysqli_query($con2, $sqlTotalSubCount);

  if ($resultTotalSubCount) {
      $subCount = mysqli_fetch_assoc($resultTotalSubCount)['total_subscribed_users'];
  } else {
      $subCount = 0;
  }

    // Fetch total payed subscribed users of the organizer's events
    $sqlTotalPayedSubCount = "
    SELECT IFNULL(SUM(payed_users), 0) AS total_payed_subscribed_users
    FROM Events
    WHERE organizer_email = '$email'
  ";
  
    $resultTotalPayedSubCount = mysqli_query($con2, $sqlTotalPayedSubCount);
  
    if ($resultTotalPayedSubCount) {
        $PayedsubCount = mysqli_fetch_assoc($resultTotalPayedSubCount)['total_payed_subscribed_users'];
    } else {
        $PayedsubCount = 0;
    }

        // Fetch total reviews
    $sqlTotalReviews = "
    SELECT COUNT(*)  as reviewsCount
    FROM reviews
    WHERE organizer_id = '$organizer_id'
  ";
  
    $resultTotalReviews = mysqli_query($con2, $sqlTotalReviews);
  
    if ($resultTotalReviews) {
        $reviews = mysqli_fetch_assoc($resultTotalReviews)['reviewsCount'];
    } else {
        $reviews = 0;
    }

    // Fetch total events
    $sqlTotalEvents = "
    SELECT COUNT(*)  as events
    FROM events
    WHERE organizer_email = '$email'
  ";
  
    $resultTotalEvents = mysqli_query($con2, $sqlTotalEvents);
  
    if ($resultTotalEvents) {
        $events = mysqli_fetch_assoc($resultTotalEvents)['events'];
    } else {
        $events = 0;
    }

    // Fetch total published events
    $sqlTotalPbEvents = "
    SELECT COUNT(*)  as Pbevents
    FROM events
    WHERE organizer_email = '$email' AND is_verified = 1 AND is_ended = 0
  ";
  
    $resultTotalPbEvents = mysqli_query($con2, $sqlTotalPbEvents);
  
    if ($resultTotalPbEvents) {
        $Pbevents = mysqli_fetch_assoc($resultTotalPbEvents)['Pbevents'];
    } else {
        $Pbevents = 0;
    }

        // Fetch total pending events
    $sqlTotalPdEvents = "
    SELECT COUNT(*)  as Pdevents
    FROM events
    WHERE organizer_email = '$email' AND is_verified = 0
  ";
  
    $resultTotalPdEvents = mysqli_query($con2, $sqlTotalPdEvents);
  
    if ($resultTotalPdEvents) {
        $Pdevents = mysqli_fetch_assoc($resultTotalPdEvents)['Pdevents'];
    } else {
        $Pdevents = 0;
    }

        // Fetch total payed subscribed users of the organizer's events
    $sqlTotalAmountRaised = "
    SELECT IFNULL(SUM(amount_users),0) AS total_amount_raised
    FROM Events
    WHERE organizer_email = '$email'
  ";
  
    $resultTotalAmountRaised = mysqli_query($con2, $sqlTotalAmountRaised);
  
    if ($resultTotalAmountRaised) {
        $AmountRaised = mysqli_fetch_assoc($resultTotalAmountRaised)['total_amount_raised'];
    } else {
        $AmountRaised = 0;
    }

    // Fetch total archived events
    $sqlTotalArchivedEvents = "
    SELECT COUNT(*)  as archivedevents
    FROM events
    WHERE organizer_email = '$email' AND is_ended = 1 
  ";
  
    $resultTotalArchivedEvents = mysqli_query($con2, $sqlTotalArchivedEvents);
  
    if ($resultTotalArchivedEvents) {
        $ArchivedEvents = mysqli_fetch_assoc($resultTotalArchivedEvents)['archivedevents'];
    } else {
        $ArchivedEvents = 0;
    }

        // Fetch avg rating
    $sqlAvgRatingEvents = "
      SELECT IFNULL(AVG(rating),0) AS average_rating FROM Reviews;
  ";
  
    $resultAvgRatingEvents = mysqli_query($con2, $sqlAvgRatingEvents);
  
    if ($resultAvgRatingEvents) {
        $AvgRating = mysqli_fetch_assoc($resultAvgRatingEvents)['average_rating'];
    } else {
        $AvgRating = 0;
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
            <div class="is-user-name"><span><?php echo isset($fetch_info['organization_name']) ? $fetch_info['organization_name'] : 'Home' ?></span></div>
            <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
          </a>
          <div class="navbar-dropdown">
              <a href="home.php" class="navbar-item">
              <span class="icon"><i class="mdi mdi mdi-desktop-mac"></i></span>
              <span>Dashboard</span>
              </a>

              
              <a href="tables.php" class="navbar-item">
              <span class="icon"><i class="mdi mdi-settings"></i></span>
              <span>Events</span>
              </a>

              <a href="subscribed-events.php" class="navbar-item">
              <span class="icon"><i class="mdi mdi-email"></i></span>
              <span>Subscribed Events</span>
              </a>

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
      <p class="menu-label">General</p>
      <ul class="menu-list">
        <li class="active">
          <a>
            <span class="icon"><i class="mdi mdi-chart-areaspline"></i></span>
            <span class="menu-item-label">Total Statistics</span>
          </a>
        </li>
        <li>
          <a href="organizer-pbevents.php">
            <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
            <span class="menu-item-label">Published Events</span>
          </a>
        </li>
        <li>
          <a href="organizer-pending.php">
            <span class="icon"><i class="mdi mdi-timetable"></i></span>
            <span class="menu-item-label">Pending Events</span>
          </a>
        </li>
        <li>
          <a href="organizer-addevents.php">
            <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
            <span class="menu-item-label">Add/Remove PbEvents</span>
          </a>
        </li>
        <li>
          <a href="organizer-archived.php">
            <span class="icon"><i class="mdi mdi-folder"></i></span>
            <span class="menu-item-label">Archived Events</span>
          </a>
        </li>
      </ul>
      <p class="menu-label">Menu</p>
      <ul class="menu-list">
        <li>
          <a href="organizer-reviews.php">
            <span class="icon"><i class="mdi mdi-star"></i></span>
            <span class="menu-item-label">Reviews</span>
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
          <a href="organizer-profile.php">
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
        <li><?php echo isset($fetch_info['organization_name']) ? $fetch_info['organization_name'] : 'Home' ?></li>
        <li>Total Statistics</li>
      </ul>

    </div>
  </section>

  <section class="is-hero-bar">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
      <h1 class="title">
        Total Statistics
      </h1>
    </div>
  </section>



    <section class="section main-section">
      <div class="grid gap-6 grid-cols-1 md:grid-cols-3 mb-6">
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Total Subscribed Users
                </h3>
                <h1>
                <?php echo $subCount; ?>
                </h1>
              </div>
              <span class="icon widget-icon text-blue-500"><i class="mdi mdi-account-multiple mdi-48px"></i></span>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Total Payed-Subscribed Users
                </h3>
                <h1>
                <?php echo $PayedsubCount; ?>
                </h1>
              </div>
              <span class="icon widget-icon text-blue-500"><i class="mdi mdi-account-multiple mdi-48px"></i></span>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Total Reviews
                </h3>
                <h1>
                <?php echo $reviews; ?>
                </h1>
              </div>
              <span class="icon widget-icon" style="color: yellow;"><i class="mdi mdi-star mdi-48px"></i></span>
            </div>
          </div>
        </div>
                <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Average Rating
                </h3>
                <h1>
                <?php echo $AvgRating; ?>
                </h1>
              </div>
              <span class="icon widget-icon" style="color: yellow;"><i class="mdi mdi-star mdi-48px"></i></span>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Total Events
                </h3>
                <h1>
                <?php echo $events; ?>
                </h1>
              </div>
              <span class="icon widget-icon text-blue-500"><i class="mdi mdi-calendar-outline mdi-48px"></i></span>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Total Published Events
                </h3>
                <h1>
                <?php echo $Pbevents; ?>
                </h1>
              </div>
              <span class="icon widget-icon text-blue-500"><i class="mdi mdi-calendar-outline mdi-48px"></i></span>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Total Pending Events
                </h3>
                <h1>
                <?php echo $Pdevents; ?>
                </h1>
              </div>
              <span class="icon widget-icon text-blue-500"><i class="mdi mdi-calendar-outline mdi-48px"></i></span>
            </div>
          </div>
        </div>
        <div class="card">
    <div class="card-content">
        <div class="flex items-center justify-between">
            <div class="widget-label">
                <h3>
                    Total Archived Events
                </h3>
                <h1>
                    <?php echo $ArchivedEvents; ?> <!-- Correct variable name here -->
                </h1>
            </div>
            <span class="icon widget-icon text-blue-500"><i class="mdi mdi-calendar-outline mdi-48px"></i></span>
        </div>
    </div>
</div>

        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Total Amount Raised
                </h3>
                <h1>
                $<?php echo $AmountRaised; ?>
                </h1>
              </div>
              <span class="icon widget-icon text-green-500"><i class="mdi mdi-cash mdi-48px"></i></span>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Total Archived Events
                </h3>
                <h1>
                <?php echo $ArchivedEvents; ?>
                </h1>
              </div>
              <span class="icon widget-icon text-green-500"><i class="mdi mdi-folder mdi-48px"></i></span>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Attendance rate
                </h3>
                <h1>
                <?php 
                  if ($subCount > 0) {
                      $ratio = ($PayedsubCount / $subCount) * 100;
                  } else {
                      // Handle the case where $subCount is zero to avoid division by zero
                      $ratio = 0;
                  }
                  echo $ratio;
                  echo "%"
                ?>
                </h1>
              </div>
              <span class="icon widget-icon text-red-500"><i class="mdi mdi-chart-line mdi-48px"></i></span>
            </div>
          </div>
        </div>

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
      </div>

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




      <br><br>


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
