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


<?php
if (isset($_GET['id'])) {
    $orgId = $_GET['id'];

    // Fetch user information based on the provided ID
    $orgSql = "SELECT * FROM organizers WHERE id = $orgId";
    $run_orgSql = mysqli_query($con, $orgSql);

    if ($run_orgSql) {
        $orgInfo = mysqli_fetch_assoc($run_orgSql);

        // Extract user information
        $profile_pic = $orgInfo['profile_pic'];
        $organizer_type = $orgInfo['organizer_type'];
        $organization_name = $orgInfo['organization_name'];
        $phone_number = $orgInfo['phone_number'];
        $email1 = $orgInfo['email'];
        $status1 = $orgInfo['status'];

        // ... (add other fields)

    } else {
        // Handle query failure
        die("Query failed: " . mysqli_error($con));
    }
} else {
    // Redirect to home or handle the case where no ID is provided
    header('Location: home.php');
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

    <div class="navbar-brand is-right">
      <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
        <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
      </a>
    </div>
    <div class="navbar-brand is-left">
    <a href="home.php" class="navbar-item">
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
            <div class="is-user-name"><span><?php echo isset($fetch_info['first_name']) ? $fetch_info['first_name'] : 'Home' ?></span></div>
            <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
          </a>
          <div class="navbar-dropdown">


          <?php
              echo '<a href="organizer-pbevents.php" class="navbar-item">';
              echo '<span class="icon"><i class="mdi mdi mdi-desktop-mac"></i></span>';
              echo '<span>Dashboard</span>';
              echo '</a>';

              echo '<a href="organizer-pending.php" class="navbar-item">';
              echo '<span class="icon"><i class="mdi mdi-settings"></i></span>';
              echo '<span>Events</span>';
              echo '</a>';

              echo '<a href="organizer-archived.php" class="navbar-item">';
              echo '<span class="icon"><i class="mdi mdi-email"></i></span>';
              echo '<span>Subscribed Events</span>';
              echo '</a>';
          
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
            Edit Profile
          </p>
        </header>
        <div class="card-content">
        <div class="image w-48 h-48 mx-auto">
        <div class="image w-48 h-48 mx-auto">
        <?php if (!empty($profile_pic) && file_exists($profile_pic)) : ?>
            <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="rounded-full">
        <?php else : ?>
            <p>No profile picture available</p>
        <?php endif; ?>
    </div>

</div>

          <hr>

          <div class="field">
            <label class="label">Organization type</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $organizer_type; ?>" class="input is-static" name="first_name">
            </div>
          </div>
          
          <div class="field">
            <label class="label">Organization name</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $organization_name; ?>" class="input is-static" name="last_name">
            </div>
          </div>

          <div class="field">
            <label class="label">Email</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $email1; ?>" class="input is-static" name="last_name">
            </div>
          </div>

          <div class="field">
            <label class="label">Phone Number</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $phone_number; ?>" class="input is-static" name="phone_number">
            </div>
          </div>

          <div class="field">
            <label class="label">Status</label>
            <div class="control">
              <input type="email" readonly value="<?php echo ($status1 == 1) ? 'Yes' : 'No'; ?>" class="input is-static" name="last_name">
            </div>
          </div>

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