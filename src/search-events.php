<?php
// Include database connection and other necessary files
require_once "controllerUserData.php";

// Check if the search query is set
if (isset($_POST['search3'])) {
    $searchQuery = mysqli_real_escape_string($con, $_POST['search3']);

    // Your SQL query for searching (modify based on your needs)
    $sqlSearch = "SELECT * FROM events
                 WHERE (id LIKE '%$searchQuery%'
                 OR organizer_email LIKE '%$searchQuery%'
                 OR event_name LIKE '%$searchQuery%'
                 OR major_target LIKE '%$searchQuery%'
                 OR description LIKE '%$searchQuery%'
                 OR faculty LIKE '%$searchQuery%'
                 OR location LIKE '%$searchQuery%'
                 OR event_date_start LIKE '%$searchQuery%'
                 OR event_date_finish LIKE '%$searchQuery%'
                 OR organizer_phone LIKE '%$searchQuery%')
                 AND is_verified = 1 AND is_ended = 0";

    $resultSearch = mysqli_query($con, $sqlSearch);

    // Check if the query was successful
    if (!$resultSearch) {
        die("Query failed: " . mysqli_error($con));
    }

    // Display search results
    if ($resultSearch->num_rows > 0) {
        while ($row = $resultSearch->fetch_assoc()) {
            echo "<tr>
                <td data-label='Event Name'>{$row['event_name']}</td>
                <td data-label='Organizer Email'>{$row['organizer_email']}</td>
                <td data-label='Major Target'>{$row['major_target']}</td>
                <td data-label='Description'>{$row['description']}</td>
                <td data-label='Duration'>{$row['event_date_finish']}</td>
                <td data-label='Faculty'>{$row['faculty']}</td>
                <td data-label='Location'>{$row['location']}</td>
                <td data-label='Event Date'>{$row['event_date_start']}</td>
                <td data-label='Event Time'>{$row['event_date_finish']}</td>
                <td data-label='Organizer Phone'>{$row['organizer_phone']}</td>
                <td class='actions-cell'>
                <div class='buttons right nowrap'>
                    <a href='views-event.php?id={$row['id']}&source=home' class='button small blue --jb-modal' data-target='sample-modal-2'>
                        <span class='icon'><i class='mdi mdi-eye'></i></span>
                    </a>
                    <a href='home.php?id={$row['id']}&action=reject2' class='button small red'>
                        <span class='icon'><i class='mdi mdi-trash-can'></i></span>
                    </a>
                </div>
                </td>
            </tr>";
        }
    } else {
        // No rows found
        echo '<div class="card empty">';
        echo '<div class="card-content">';
        echo '<div>';
        echo '<span class="icon large"><i class="mdi mdi-emoticon-sad mdi-48px"></i></span>';
        echo '</div>';
        echo "<p>Nothing's here…</p>";
        echo '</div>';
        echo '</div>';
    }
}
?>
