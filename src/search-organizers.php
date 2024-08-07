<?php
// Include database connection and other necessary files
require_once "controllerUserData.php";

// Check if the search query is set
if (isset($_POST['search2'])) {
   $searchQuery = mysqli_real_escape_string($con, $_POST['search2']);

   // Your SQL query for searching (modify based on your needs)
   $sqlSearch = "SELECT id, profile_pic, organizer_type, organization_name, phone_number, email, status FROM organizers
                 WHERE id LIKE '%$searchQuery%'
                 OR profile_pic LIKE '%$searchQuery%'
                 OR organizer_type LIKE '%$searchQuery%'
                 OR organization_name LIKE '%$searchQuery%'
                 OR phone_number LIKE '%$searchQuery%'
                 OR email LIKE '%$searchQuery%'
                 OR status LIKE '%$searchQuery%'";

   $resultSearch = mysqli_query($con, $sqlSearch);

   // Check if the query was successful
   if (!$resultSearch) {
      die("Query failed: " . mysqli_error($con));
   }

   // Display search results
   if ($resultSearch->num_rows > 0) {
      while ($row = $resultSearch->fetch_assoc()) {
         echo "<tr>
            <td data-label='ID'>{$row['id']}</td>
            <!-- Add other <td> elements for each column you have in the database -->
            <td class='image-cell'>
               <div class='image'>
                  <img src='{$row['profile_pic']}' class='rounded-full'>
               </div>
            </td>
            <td data-label='Organizer Type'>{$row['organizer_type']}</td>
            <td data-label='Organization Name'>{$row['organization_name']}</td>
            <td data-label='Email'>{$row['email']}</td>
            <td data-label='Phone Number'>{$row['phone_number']}</td>
            <td data-label='Status'><?php echo ({$row['status']} == 'verified') ? 'Yes' : 'No'; ?></td>
            <td class='actions-cell'>
               <div class='buttons right nowrap'>
                  <a href='views-organizer.php?id={$row['id']}' class='button small blue --jb-modal' data-target='sample-modal-2'>
                     <span class='icon'><i class='mdi mdi-eye'></i></span>
                  </a>
                  <a href='home.php?id={$row['id']}&action=reject1' class='button small red'>
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
