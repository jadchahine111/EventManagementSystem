<?php 
session_start();
$con = mysqli_connect('localhost', 'jadchahine', 'jadali123');
if ($con) {
    mysqli_select_db($con, "evlu");
} else {
    die("Connection failed: " . mysqli_connect_error());
}
$email = "jadalichahine@gmail.com";
$name = "Jad Chahine";
$errors = array();

// if user signup button
if (isset($_POST['signup'])) {
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $fileno = mysqli_real_escape_string($con, $_POST['fileno']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $faculty = mysqli_real_escape_string($con, $_POST['faculty']);
    $major = mysqli_real_escape_string($con, $_POST['major']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    }

    // Check if email is already used in Users or Organizers table
    $email_check_users = "SELECT email FROM users WHERE email = '$email'";
    $email_check_org = "SELECT email FROM organizers WHERE email = '$email'";
    
    $res_users = mysqli_query($con, $email_check_users);
    $res_org = mysqli_query($con, $email_check_org);

    if ($res_users === false || $res_org === false) {
        $errors['db-error'] = "Error executing query: " . mysqli_error($con);
    } else {
        if (mysqli_num_rows($res_users) > 0 || mysqli_num_rows($res_org) > 0) {
            $errors['email'] = "Email that you have entered already exists!";
        }

        // Insert Unverified User into Database Users
        if (count($errors) === 0) {
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            $code = rand(999999, 111111);
            $status = "notverified";
            
            // Insert data into Users table
            $insert_data_users = "INSERT INTO users (first_name, last_name, file_no, email, faculty, major, password, phone_number, code, status, is_admin)
            VALUES ('$first_name', '$last_name', '$fileno', '$email', '$faculty', '$major', '$encpass', '$phone_number', '$code', '$status', '0')";
            $data_check_users = mysqli_query($con, $insert_data_users);

            // Email Verification when registering
            if ($data_check_users) {
                $subject = "Email Verification Code";
                $message = "Your verification code is $code";
                $sender = "From: jadalichahine@gmail.com";
                if (mail($email, $subject, $message, $sender)) {
                    $info = "We've sent a verification code to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
                    header('location: user-otp.php');
                    exit();
                } else {
                    $errors['otp-error'] = "Failed while sending code!";
                }
            } else {
                $errors['db-error'] = "Error executing query for Users: " . mysqli_error($con);
            }
        }
    }
}



// If organizer signup button
if (isset($_POST['signup-organizer'])) {
    $phone_number =  mysqli_real_escape_string($con, $_POST['phone_number']);
    $org_type = mysqli_real_escape_string($con, $_POST['organizer_type']);
    $org_name = mysqli_real_escape_string($con, $_POST['organization_name']);
    $org_email = mysqli_real_escape_string($con, $_POST['email']);
    $org_password = mysqli_real_escape_string($con, $_POST['password']);
    $org_cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    if ($org_password !== $org_cpassword) {
        $errors['password'] = "Confirm password not matched!";
    }

    // Check if email is already used in Organizers table
    $org_email_check_organizers = "SELECT email FROM organizers WHERE email = '$org_email'";
    $org_res_organizers = mysqli_query($con, $org_email_check_organizers);

    // Check if email is already used in Users table
    $org_email_check_users = "SELECT email FROM users WHERE email = '$org_email'";
    $org_res_users = mysqli_query($con, $org_email_check_users);

    if ($org_res_organizers === false || $org_res_users === false) {
        $errors['db-error'] = "Error executing query: " . mysqli_error($con);
    } else {
        $organizers_email_exists = mysqli_num_rows($org_res_organizers) > 0;
        $users_email_exists = mysqli_num_rows($org_res_users) > 0;

        if ($organizers_email_exists || $users_email_exists) {
            $errors['email'] = "Email that you have entered already exists!";
        }

        // Insert Unverified Organizer into Database Organizers
        if (count($errors) === 0) {
            $encpass = password_hash($org_password, PASSWORD_BCRYPT);
            $code = rand(999999, 111111);
            $status = "notverified";
            $is_verified = 0; // Set is_verified to 0 for new entries
            $insert_org_data = "INSERT INTO organizers (organizer_type, organization_name, email, password, code, status, is_verified, phone_number)
            VALUES ('$org_type', '$org_name', '$org_email', '$encpass', '$code', '$status', '$is_verified', '$phone_number')";
            $org_data_check = mysqli_query($con, $insert_org_data);

            // Email Verification when registering
            if ($org_data_check) {
                $subject = "Email Verification Code";
                $message = "Your verification code is $code";
                $sender = "From: jadalichahine@gmail.com";
                if (mail($org_email, $subject, $message, $sender)) {
                    $info = "We've sent a verification code to your email - $org_email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $org_email;
                    $_SESSION['password'] = $org_password;
                    header('location: user-otp.php');
                    exit();
                } else {
                    $errors['otp-error'] = "Failed while sending code!";
                }
            } else {
                $errors['db-error'] = "Error executing query for Organizers: " . mysqli_error($con);
            }
        }
    }
}



// if user and organizer click verification code submit button
if (isset($_POST['check'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
    $email = $_SESSION['email']; 

    // Check if the verification code matches for users
    $check_code_user = "SELECT * FROM users WHERE code = $otp_code AND email = '$email'";
    $code_res_user = mysqli_query($con, $check_code_user);

    // Check if the verification code matches for organizers
    $check_code_org = "SELECT * FROM organizers WHERE code = $otp_code AND email = '$email'";
    $code_res_org = mysqli_query($con, $check_code_org);

    if (mysqli_num_rows($code_res_user) > 0) {
        $code = 0;
        $status = 'verified';

        // Update status for users
        $update_otp_user = "UPDATE users SET code = $code, status = '$status' WHERE code = $otp_code AND email = '$email'";
        $update_res_user = mysqli_query($con, $update_otp_user);

        if ($update_res_user) {
            $_SESSION['email'] = $email;
            $isAdmin = $fetch['is_admin'];
            if ($isAdmin == 0) {
                header('Location: tables.php'); // Redirect non-admin user to tables.php
                exit();
            } else {
                header('Location: home.php'); // Redirect admin user to home.php
                exit();
            }
        } else {
            $errors['otp-error'] = "Failed while updating code for user!";
        }
    } elseif (mysqli_num_rows($code_res_org) > 0) {
        $code = 0;
        $status = 'verified';

        // Update status for organizers
        $update_otp_org = "UPDATE organizers SET code = $code, status = '$status' WHERE code = $otp_code AND email = '$email'";
        $update_res_org = mysqli_query($con, $update_otp_org);

        if ($update_res_org) {
            $_SESSION['email'] = $email;
            header('Location: organizer-statistics.php'); // Redirect organizer to organizer-statistics.php
            exit();
        } else {
            $errors['otp-error'] = "Failed while updating code for organizer!";
        }
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}








// if user and organizer click login button
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Check if the email exists in the users table
    $check_user_email = "SELECT * FROM users WHERE email = '$email'";
    $user_res = mysqli_query($con, $check_user_email);

    // Check if the email exists in the organizers table
    $check_org_email = "SELECT * FROM organizers WHERE email = '$email'";
    $org_res = mysqli_query($con, $check_org_email);

    if (mysqli_num_rows($user_res) > 0) {
        // User login logic
        $fetch = mysqli_fetch_assoc($user_res);
        $fetch_pass = $fetch['password'];
        if (password_verify($password, $fetch_pass)) {
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $status = $fetch['status'];
            if ($status == 'verified') {
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $isAdmin = $fetch['is_admin'];
                if ($isAdmin == 0) {
                    header('location: tables.php');
                } else {
                    header('location: home.php');
                }
            } else {
                $info = "It's look like you haven't still verified your email - $email";
                $_SESSION['info'] = $info;
                header('location: user-otp.php');
            }
        } else {
            $errors['email'] = "Incorrect email or password!";
        }
    } elseif (mysqli_num_rows($org_res) > 0) {
        // Organizer login logic
        $fetch = mysqli_fetch_assoc($org_res);
        $fetch_pass = $fetch['password'];
        if (password_verify($password, $fetch_pass)) {
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $status = $fetch['status'];
            if ($status == 'verified') {
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: organizer-statistics.php'); // Adjust the redirect URL
            } else {
                $info = "It's look like you haven't still verified your email - $email";
                $_SESSION['info'] = $info;
                header('location: user-otp.php');
            }
        } else {
            $errors['email'] = "Incorrect email or password!";
        }
    } else {
        $errors['email'] = "It's look like you're not yet a member! Click on the bottom link to sign up.";
    }
}





// if user and organizer click continue button in forgot password form
if(isset($_POST['check-email'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Check if the email exists in the users table
    $check_user_email = "SELECT * FROM users WHERE email='$email'";
    $user_res = mysqli_query($con, $check_user_email);

    // Check if the email exists in the organizers table
    $check_org_email = "SELECT * FROM organizers WHERE email='$email'";
    $org_res = mysqli_query($con, $check_org_email);

    if(mysqli_num_rows($user_res) > 0){
        // User password reset logic
        $code = rand(999999, 111111);
        $insert_code = "UPDATE users SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($con, $insert_code);
        if($run_query){
            $subject = "Password Reset Code";
            $message = "Your password reset code is $code";
            $sender = "From: jadalichahine@gmail.com";
            if(mail($email, $subject, $message, $sender)){
                $info = "We've sent a password reset otp to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            }else{
                $errors['otp-error'] = "Failed while sending code!";
            }
        }else{
            $errors['db-error'] = "Something went wrong!";
        }
    } elseif(mysqli_num_rows($org_res) > 0) {
        // Organizer password reset logic
        $code = rand(999999, 111111);
        $insert_code = "UPDATE organizers SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($con, $insert_code);
        if($run_query){
            $subject = "Password Reset Code";
            $message = "Your password reset code is $code";
            $sender = "From: jadalichahine@gmail.com";
            if(mail($email, $subject, $message, $sender)){
                $info = "We've sent a password reset otp to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            }else{
                $errors['otp-error'] = "Failed while sending code!";
            }
        }else{
            $errors['db-error'] = "Something went wrong!";
        }
    } else {
        $errors['email'] = "This email address does not exist!";
    }
}




// if user and organizer click check reset otp button
if(isset($_POST['check-reset-otp'])){
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
    
    // Check if the OTP exists in the users table
    $check_user_code = "SELECT * FROM users WHERE code = $otp_code";
    $user_code_res = mysqli_query($con, $check_user_code);

    // Check if the OTP exists in the organizers table
    $check_org_code = "SELECT * FROM organizers WHERE code = $otp_code";
    $org_code_res = mysqli_query($con, $check_org_code);

    if(mysqli_num_rows($user_code_res) > 0){
        // User OTP verification logic
        $fetch_data = mysqli_fetch_assoc($user_code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new-password.php');
        exit();
    } elseif(mysqli_num_rows($org_code_res) > 0) {
        // Organizer OTP verification logic
        $fetch_data = mysqli_fetch_assoc($org_code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new-password.php');
        exit();
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}


// --------------------------------------------------------------------------------






   
if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    $email = $_SESSION['email'];

    // Check if the new password is the same as the current password for users
    $check_current_password_query_user = "SELECT password FROM users WHERE email = '$email'";
    $check_current_password_result_user = mysqli_query($con, $check_current_password_query_user);
    $row_user = mysqli_fetch_assoc($check_current_password_result_user);

    // Check if the new password is the same as the current password for organizers
    $check_current_password_query_org = "SELECT password FROM organizers WHERE email = '$email'";
    $check_current_password_result_org = mysqli_query($con, $check_current_password_query_org);
    $row_org = mysqli_fetch_assoc($check_current_password_result_org);

    if ($row_user !== null) {
        $currentPasswordHash_user = $row_user['password'];

        if (password_verify($password, $currentPasswordHash_user)) {
            $errors['password'] = "Password already used. Please choose another one.";
        } elseif ($password !== $cpassword) {
            $errors['password'] = "Confirm password not matched!";
        } else {
            $code = 0;
            $encpass = password_hash($password, PASSWORD_BCRYPT);

            // Update password for users
            $update_pass_user = "UPDATE users SET code = $code, password = '$encpass' WHERE email = '$email'";
            $run_query_user = mysqli_query($con, $update_pass_user);

            if ($run_query_user !== false) {
                $info = "Your password changed. Now you can login with your new password.";
                $_SESSION['info'] = $info;
                header('Location: password-changed.php');
                exit(); // Ensure that no further code is executed after the redirect
            } else {
                $errors['db-error'] = "Failed to change your password for users!";
            }
        }
    } elseif ($row_org !== null) {
        $currentPasswordHash_org = $row_org['password'];

        if (password_verify($password, $currentPasswordHash_org)) {
            $errors['password'] = "Password already used. Please choose another one.";
        } elseif ($password !== $cpassword) {
            $errors['password'] = "Confirm password not matched!";
        } else {
            $code = 0;
            $encpass = password_hash($password, PASSWORD_BCRYPT);

            // Update password for organizers
            $update_pass_org = "UPDATE organizers SET code = $code, password = '$encpass' WHERE email = '$email'";
            $run_query_org = mysqli_query($con, $update_pass_org);

            if ($run_query_org !== false) {
                $info = "Your password changed. Now you can login with your new password.";
                $_SESSION['info'] = $info;
                header('Location: password-changed.php');
                exit(); // Ensure that no further code is executed after the redirect
            } else {
                $errors['db-error'] = "Failed to change your password for organizers!";
            }
        }
    } else {
        $errors['db-error'] = "Failed to check the current password!";
    }
} else {
    // Handle the case when 'change-password' is not set
}





   //if login now button click
   if(isset($_POST['login-now'])){
    header('Location: login-user.php');
}





?>
