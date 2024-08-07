    <?php
    // Include your configuration file if you create one
    // require_once 'config.php';

    // Database connection parameters
    $servername = "localhost";
    $username = "jadchahine";
    $password = "jadali123";
    $dbname = "evlu";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create database
    $sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql_create_db) === TRUE) {
        echo "Database created successfully\n";
    } else {
        echo "Error creating database: " . $conn->error . "\n";
    }

    // Select the created database
    $conn->select_db($dbname);

    // Create Users table with INT column
    $sql_create_users_table = "
    CREATE TABLE IF NOT EXISTS Users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        profile_pic VARCHAR(255),
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        file_no INT NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        faculty VARCHAR(50) NOT NULL,
        major VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        phone_number INT,   
        code INT NOT NULL,
        is_admin BOOLEAN NOT NULL DEFAULT 0,
        status TEXT NOT NULL
    )";
    if ($conn->query($sql_create_users_table) === TRUE) {
        echo "Users table created successfully\n";
    } else {
        echo "Error creating Users table: " . $conn->error . "\n";
    }

    $sql_create_organizers_table = "
    CREATE TABLE IF NOT EXISTS Organizers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        profile_pic VARCHAR(255),
        organizer_type ENUM('individual', 'organization') NOT NULL,
        organization_name VARCHAR(255),
        phone_number INT NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        code INT NOT NULL, 
        is_verified BOOLEAN NOT NULL DEFAULT 0,
        status TEXT NOT NULL
    )";
    if ($conn->query($sql_create_organizers_table) === TRUE) {
        echo "Organizers table created successfully\n";
    } else {
        echo "Error creating Organizers table: " . $conn->error . "\n";
    }

    // Create Events table
    $sql_create_events_table = "
    CREATE TABLE IF NOT EXISTS Events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        organizer_email VARCHAR(100) NOT NULL,
        event_name VARCHAR(255) NOT NULL,
        major_target VARCHAR(100) NOT NULL,
        description TEXT,
        faculty VARCHAR(50),
        location VARCHAR(100),
        event_date_start DATETIME,
        event_date_finish DATETIME,
        organizer_phone INT,
        price INT,
        is_ended BOOLEAN NOT NULL DEFAULT 0,
        sub_users INT DEFAULT 0,
        amount_users INT DEFAULT 0,
        payed_users INT DEFAULT 0,
        is_verified INT DEFAULT 0
    )";
    if ($conn->query($sql_create_events_table) === TRUE) {
        echo "Events table created successfully\n";
    } else {
        echo "Error creating Events table: " . $conn->error . "\n";
    }

        // Create Reviews table
        $sql_create_events_table = "
        CREATE TABLE IF NOT EXISTS Reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            organizer_id INT,
            event_id INT,
            rating INT,
            comment TEXT,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (organizer_id) REFERENCES organizers(id),
            FOREIGN KEY (event_id) REFERENCES events(id)
        )";
        if ($conn->query($sql_create_events_table) === TRUE) {
            echo "Reviews table created successfully\n";
        } else {
            echo "Error creating Reviews table: " . $conn->error . "\n";
        }

        // Create Subscription table
        $sql_create_subscription_table  = "
        CREATE TABLE IF NOT EXISTS Subscriptions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            event_id INT,
            is_paid BOOLEAN NOT NULL DEFAULT 0,
            FOREIGN KEY (user_id) REFERENCES Users(id),
            FOREIGN KEY (event_id) REFERENCES Events(id)
        );
        
        
        ";
        if ($conn->query($sql_create_subscription_table) === TRUE) {
            echo "Subscription table created successfully\n";
        } else {
            echo "Error creating Subscription table: " . $conn->error . "\n";
        }

    // Insert admin user
    $admin_first_name = "Jad";
    $admin_last_name = "Chahine";
    $admin_email = "jad.chahine.2@st.ul.edu.lb";
    $admin_password = password_hash("J@dchahine12", PASSWORD_DEFAULT);
    $admin_phone_number = 70518541; // Update with the actual phone number
    $admin_faculty = "Sciences";
    $admin_major = "Computer Science";
    $admin_file_no = 104384;
    $admin_code = 0;

    // Use prepared statement to prevent SQL injection
    $sql_insert_admin_user = $conn->prepare("
    INSERT INTO Users (first_name, last_name, email, password, file_no, phone_number, faculty, major, is_admin, code, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?, 'verified')");

    // Check for errors in prepare
    if (!$sql_insert_admin_user) {
        die("Error in prepare: " . $conn->error);
    }

    $sql_insert_admin_user->bind_param("ssssisssi", $admin_first_name, $admin_last_name, $admin_email, $admin_password, $admin_file_no, $admin_phone_number, $admin_faculty, $admin_major, $admin_code);

    // Check for errors in bind_param
    if ($sql_insert_admin_user->errno) {
        die("Error in bind_param: " . $sql_insert_admin_user->error);
    }

    if ($sql_insert_admin_user->execute()) {
        echo "Admin user inserted successfully\n";
    } else {
        echo "Error inserting admin user: " . $sql_insert_admin_user->error . "\n";
    }

    // Close prepared statement
    $sql_insert_admin_user->close();



    // Close connection
    $conn->close();






// Organizer table: id - user_id (foreign key) - organization type (individual or organization) -  organization_name - email - password - phone_number - code






?>




