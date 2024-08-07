<?php
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Assuming $con is your database connection
    $con = mysqli_connect('localhost', 'jadchahine', 'jadali123', 'evlu');
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch event details from the database
    $getEventDetailsQuery = "SELECT * FROM Events WHERE id = $eventId";
    $resultEventDetails = mysqli_query($con, $getEventDetailsQuery);

    if ($resultEventDetails && $rowEventDetails = mysqli_fetch_assoc($resultEventDetails)) {
        // Get total subscribed users
        $getTotalSubscribedUsersQuery = "SELECT COUNT(id) AS total_subscribed FROM Subscriptions WHERE event_id = $eventId";
        $resultTotalSubscribedUsers = mysqli_query($con, $getTotalSubscribedUsersQuery);
        $rowTotalSubscribedUsers = mysqli_fetch_assoc($resultTotalSubscribedUsers);
        $totalSubscribedUsers = $rowTotalSubscribedUsers['total_subscribed'];

        // Get total payed subscribed users
        $getTotalPayedSubscribedUsersQuery = "SELECT COUNT(id) AS total_payed_subscribed FROM Subscriptions WHERE event_id = $eventId AND is_paid = 1";
        $resultTotalPayedSubscribedUsers = mysqli_query($con, $getTotalPayedSubscribedUsersQuery);
        $rowTotalPayedSubscribedUsers = mysqli_fetch_assoc($resultTotalPayedSubscribedUsers);
        $totalPayedSubscribedUsers = $rowTotalPayedSubscribedUsers['total_payed_subscribed'];

        // Calculate attendance rate
        $attendanceRate = ($totalSubscribedUsers > 0) ? ($totalPayedSubscribedUsers / $totalSubscribedUsers) * 100 : 0;

        // Get total reviews
        $getTotalReviewsQuery = "SELECT COUNT(id) AS total_reviews FROM Reviews WHERE event_id = $eventId";
        $resultTotalReviews = mysqli_query($con, $getTotalReviewsQuery);
        $rowTotalReviews = mysqli_fetch_assoc($resultTotalReviews);
        $totalReviews = $rowTotalReviews['total_reviews'];

        // Get average rating
        $getAverageRatingQuery = "SELECT AVG(rating) AS average_rating FROM Reviews WHERE event_id = $eventId";
        $resultAverageRating = mysqli_query($con, $getAverageRatingQuery);
        $rowAverageRating = mysqli_fetch_assoc($resultAverageRating);
        $averageRating = round($rowAverageRating['average_rating'], 2);

        // Get amount raised
        $amountRaised = $rowEventDetails['amount_users'];

        // Define the file name based on the event name
        $fileName = sanitizeFileName($rowEventDetails['event_name']) . "_statistics.txt";

        // Create the statistics string
        $statistics = "Event Name: " . $rowEventDetails['event_name'] . "\n";
        $statistics .= "Total Subscribed Users: $totalSubscribedUsers\n";
        $statistics .= "Total Payed Subscribed Users: $totalPayedSubscribedUsers\n";
        $statistics .= "Attendance Rate: $attendanceRate%\n";
        $statistics .= "Total Reviews: $totalReviews\n";
        $statistics .= "Average Rating: $averageRating\n";
        $statistics .= "Amount Raised: $$amountRaised\n";

        // Save the statistics to the file in the same directory as the script
        file_put_contents($fileName, $statistics);

        // Close the database connection
        mysqli_close($con);

        // Provide a download link for the generated statistics
        echo "<p>Statistics generated successfully!</p>";
        echo "<p>Download Statistics: <a href='$fileName' download>Download</a></p>";
    } else {
        echo "Error fetching event details.";
    }
} else {
    echo "Event ID not provided.";
}

// Function to sanitize a string for use as a file name
function sanitizeFileName($fileName)
{
    // Remove unwanted characters
    $fileName = preg_replace("/[^a-zA-Z0-9\s]/", "", $fileName);
    // Replace spaces with underscores
    $fileName = str_replace(' ', '_', $fileName);
    return $fileName;
}
?>
