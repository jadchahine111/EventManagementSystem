<?php
// Include database connection and other necessary files
require_once "controllerUserData.php";

// Check if the search query is set
if (isset($_POST['search'])) {
   $searchQuery = mysqli_real_escape_string($con, $_POST['search']);

   $sqlSearch = "SELECT id, profile_pic, first_name, last_name, file_no, email, faculty, major, phone_number FROM users
   WHERE (id LIKE '%$searchQuery%' AND is_admin = '0')
   OR (first_name LIKE '%$searchQuery%' AND is_admin = '0')
   OR (last_name LIKE '%$searchQuery%' AND is_admin = '0')
   OR (file_no LIKE '%$searchQuery%' AND is_admin = '0')
   OR (email LIKE '%$searchQuery%' AND is_admin = '0')
   OR (faculty LIKE '%$searchQuery%' AND is_admin = '0')
   OR (major LIKE '%$searchQuery%' AND is_admin = '0')
   OR (phone_number LIKE '%$searchQuery%' AND is_admin = '0')";


   $resultSearch = mysqli_query($con, $sqlSearch);

   // Check if the query was successful
   if (!$resultSearch) {
      die("Query failed: " . mysqli_error($con));
   }

   // Display search results
   if ($resultSearch->num_rows > 0) {
      while ($row = $resultSearch->fetch_assoc()) {
         echo "<tr>
            <!-- Add other <td> elements for each column you have in the database -->
            <td class='image-cell'>
               <div class='image'>
                  <img src='{$row['profile_pic']}' class='rounded-full'>
               </div>
            </td>
            <td data-label='First Name'>{$row['first_name']}</td>
            <td data-label='Last Name'>{$row['last_name']}</td>
            <td data-label='FileNo'>{$row['file_no']}</td>
            <td data-label='Email'>{$row['email']}</td>
            <td data-label='Faculty'>{$row['faculty']}</td>
            <td data-label='Major'>{$row['major']}</td>
            <td data-label='Phone Number'>{$row['phone_number']}</td>
            <td class='actions-cell'>
               <div class='buttons right nowrap'>
                  <a href='views-user.php?id={$row["id"]}' class='button small blue --jb-modal' data-target='sample-modal-2'>
                     <span class='icon'><i class='mdi mdi-eye'></i></span>
                  </a>
                  <a href='home.php?id={$row["id"]}&action=reject1' class='button small red'>
                     <span class='icon'><i class='mdi mdi-trash-can'></i></span>
                  </a>
               </div>
            </td>
         </tr>";
      }
   }else {
      // No rows found
      //echo '<div class="card empty">';
      // echo '<div class="card-content">';
      //echo '<div>';
      //echo '<span class="icon large"><i class="mdi mdi-emoticon-sad mdi-48px"></i></span>';
      //echo '</div>';
      //echo "<p>Nothing's here…</p>";
      //echo '</div>';
      //echo '</div>';
   }
}
?>

