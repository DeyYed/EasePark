<?php
session_start();
require('../connection.php');
if (!isset($_SESSION["logined"])) {
  header("Location: ../");
}

$email = $_SESSION["email"];

date_default_timezone_set('Asia/Manila');

// Get the current server time
$serverTime = date('Y-m-d h:i A'); // 12-hour format with AM/PM
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="icon" href="../parkingstatus/image/favicon.ico" type="image/x-icon"> 
  <link rel="stylesheet" href="../css/admin_dashboard.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="sweetalert2.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="header">
    <div class="logo-container">
      <img class="cyberpark-logo" src="image/logo1.png">
    </div>
    <div class="name-edit-container">
      <div class="website-name">
        <p>EasePark</p>
      </div>
    </div>
  </div>
  <div class="left-dashboard">
    <div class="son-left-dashboard">
      <!-- <a class="son-dashboard" href="admin_dashboard.php">Dashboard</a>
      <div class="son-dashboard">
          Payment
      </div> 
      <a class="son-dashboard" href="data.php">RFID Account</a>
      <a class="son-dashboard" href="data.php">Parking Status</a>
      <a class="son-dashboard" href="parking_logs.php">Parking Logs</a> -->
      <a class="cta" href="../dashboard/"><span>
          <image class="icon1" src="icons/dashboard.png"></image>Dashboard
        </span></a>
      <!-- <div class="son-dashboard">
            Payment
        </div>  -->
      <a class="cta" href="../data/"><span>
          <image class="icon" src="icons/rfid.png"></image>RFID Account
        </span></a>
      <a class="cta" href="../parkingstatus/"><span>
          <image class="icon" src="icons/parkingstats.png"></image>Parking Status
        </span></a>
      <a class="cta" href="../parkinglogs/"><span>
          <image class="icon" src="icons/parkinglogs.png"></image>Parking Logs
        </span></a>
    </div>
    <div class="son-profile">
      <img class="profile-icon" src="icons/Profile.png">
      <button class="edit-button js-edit-button">
        <p><?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : "Email not set"; ?></p>
      </button>
      <div class="logout-container">
        <button id="logoutBtn">
          <img class="logout-icon" src="image/logout.png" alt="Logout">
        </button>
        <button class="button-logout" id="logoutBtnAlt">Logout</button>
        <form id="logoutForm" action="../logout.php" method="POST" style="display: none;">
          <input type="hidden" name="logout" value="1">
        </form>
      </div>
    </div>
  </div>

  <div class="middle">
    <div class="middle-left">
      <div class="left-one">
        <div class="left-one-title">
          Parking Status
        </div>
        <div class="left-one-status">
          <div class="total-parking-slots">
            <p class="total-p-slots">Total Parking Slots</p>
            <div class="inner-parking-slots">
              <div class="inner-count-slots js-total-slots">
                6
              </div>
              <div class="inner-parking-logo">
                <img src="image/total-parking-slots.png">
              </div>
            </div>
          </div>
          <div class="available-slots">
            <p class="total-p-slots">Available Slots</p>
            <div class="inner-parking-slots">
              <div class="inner-count-slots js-available-slots">
                0
              </div>
              <div class="inner-parking-logo">
                <img src="image/available-slots.png">
              </div>
            </div>
          </div>
          <div class="occupied-slots">
            <p class="total-p-slots">Occupied Slots</p>
            <div class="inner-parking-slots">
              <div class="inner-count-slots js-occupied-slots">
                0
              </div>
              <div class="inner-parking-logo">
                <img src="image/occupied-slots.png">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="left-two">
        <div class="title-recently-table">
          Recently Added RFID Users
        </div>
        <div class="recently-table-container">
          <div class="table">
          <?php
            // Define the datetime threshold (e.g., ten days ago from now)
            $dateThreshold = date('Y-m-d H:i:s', strtotime('-10 day')); // Adjust as needed

            // Prepare SQL query with a WHERE clause to filter by reg_date and order by reg_date descending
            $stmt = $pdo->prepare("SELECT * FROM rfid_user WHERE reg_date > ? ORDER BY reg_date DESC");
            $stmt->execute([$dateThreshold]);
            $rows = $stmt->fetchAll();

            echo "<table class='recently-data-table'>
                      <tr>
                        <th class='table-header'>First Name</th>
                        <th class='table-header'>Last Name</th>
                        <th class='table-header'>Email</th>
                        <th class='table-header'>UID</th>
                        <th class='table-header'>Plate Number</th>
                      </tr>";

            $index = 1;
            if ($rows) {
              foreach ($rows as $row) {
                if ($index % 2 !== 0) {
                  echo "<tr class='table-row'>
                            <td class='padded-cell'>" . htmlspecialchars($row->first_name) . "</td>
                            <td class='padded-cell'>" . htmlspecialchars($row->last_name) . "</td>
                            <td class='padded-cell'>" . htmlspecialchars($row->user_email) . "</td>
                            <td class='padded-cell'>" . htmlspecialchars($row->rfid_uid) . "</td> 
                            <td class='padded-cell'>" . htmlspecialchars($row->plate_number) . "</td> 
                          </tr>";
                } else {
                  echo "<tr>
                            <td class='padded-cell'>" . htmlspecialchars($row->first_name) . "</td>
                            <td class='padded-cell'>" . htmlspecialchars($row->last_name) . "</td>
                            <td class='padded-cell'>" . htmlspecialchars($row->user_email) . "</td>
                            <td class='padded-cell'>" . htmlspecialchars($row->rfid_uid) . "</td>
                            <td class='padded-cell'>" . htmlspecialchars($row->plate_number) . "</td>  
                        </tr>";
                }
                $index++;
              }
            }
            echo "</table>";
            ?>
          </div>
        </div>
      </div>
      <!-- <div class="left-three">
                width 100%
            </div> -->
    </div>
    <div class="middle-right">
      <div class="left-four">
        <div class="month-year">
          <div id="clock" class="spacing">
            <?php echo $serverTime . "pm"; ?>
          </div>
          <div class="month-year-margin">
            <?php
            // Set the timezone to your preferred timezone
            date_default_timezone_set('Asia/Manila');

            // Get the current month and year
            $current_month = date('F'); // Full textual representation of the month (e.g., January)
            $current_year = date('Y'); // 4-digit year (e.g., 2024)

            // Output formatted month and year
            echo "{$current_month}, {$current_year}";
            ?>
          </div>
        </div>
        <div class="calendar-container">
          <table class="calendar-table">
            <tr>
              <th>Mon</th>
              <th>Tue</th>
              <th>Wed</th>
              <th>Thu</th>
              <th>Fri</th>
              <th>Sat</th>
              <th>Sun</th>
            </tr>
            <tr>
              <?php
              // Get the current date
              $current_date = date('Y-m-d');

              // Calculate the start date (Monday) of the current week
              $start_date = date('Y-m-d', strtotime('this week', strtotime($current_date)));

              // Loop through each day of the week
              for ($i = 0; $i < 7; $i++) {
                $current_day = date('Y-m-d', strtotime("+$i days", strtotime($start_date)));

                // Check if it's the current date
                $highlight_class = ($current_day == $current_date) ? 'highlight' : '';

                // Output the day
                echo "<td class='{$highlight_class}'>" . date('d', strtotime($current_day)) . "</td>";
              }
              ?>
            </tr>
          </table>
        </div>
      </div>
      <div class="left-five">
        <div class="title-recently-table">
          Parking Logs
        </div>
        <div class="recently-table-container">
          <div class="table">
            <?php
            // Define the datetime threshold (e.g., three days ago from now)
            // $dateThreshold = date('Y-m-d H:i:s', strtotime('-10 day')); // Adjust as needed

            $sql = "
            SELECT * FROM parking_logs 
            WHERE (time_out IS NOT NULL OR time_in IS NOT NULL)
            AND (DATE(time_in) = CURDATE() OR DATE(time_out) = CURDATE())
            ORDER BY COALESCE(time_out, time_in) DESC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();

            // echo "<table class='recently-data-table'>
            //         <tr>
            //           <th class='table-header'>UID</th>
            //           <th class='table-header'>Route</th>
            //           <th class='table-header'>Time</th>
            //         </tr>";
            if ($rows) {
              echo "<div class='mother-data'>";
              foreach ($rows as $index => $row) {
                if (isset($row->time_in)) {
                  echo "<div class='data-raw'>
                          <div class='route-entry'>
                              <span class='data-entry'>Entry</span>
                              <span class='vertical-line'></span>
                          </div>
                          <div class='data-uid-datetime'>
                            <span class='data-uid'>" . htmlspecialchars($row->plate_number) . "</span>
                            <span class='data-datetime'>" . htmlspecialchars($row->time_in) . "</span>
                          </div>
                        </div>";
                }
              }
              echo "</div>";
            }
            if ($rows) {
              echo "<div class='mother-data'>";
              foreach ($rows as $index => $row) {
                if (isset($row->time_in) && isset($row->time_out)) {
                  echo "<div class='data-row'>
                          <div class='route-exit'>
                              <span class='data-exit'>Exit</span>
                              <span class='vertical-line'></span>
                          </div>
                          <div class='data-uid-datetime'>
                              <span class='data-uid'>" . htmlspecialchars($row->plate_number) . "</span>
                              <span class='data-datetime'>" . htmlspecialchars($row->time_out) . "</span>
                          </div>
                        </div>";
                }
              }
              echo "</div>";
            }

            //       }if (isset($row->time_in) && empty($row->time_out)) {
            //         echo "<div class='data-raw'>
            //   <div class='route-entry'>
            //       <span class='data-entry'>Entry</span>
            //       <span class='vertical-line'></span>
            //   </div>
            //   <div class='data-uid-datetime'>
            //       <span class='data-uid'>" . htmlspecialchars($row->rfid_uid) . "</span>
            //       <span class='data-datetime'>" . htmlspecialchars($row->time_out) . "</span>
            //   </div>
            // </div>";
            //           // echo "<p class='table-row'>
            //           // <span class='padded-cell'>" . htmlspecialchars($row->rfid_uid) . "</span>
            //           // <span class='route-entry'>" . "Entry" . "</span>
            //           // <span class='padded-cell'>" . htmlspecialchars($row->time_out) . "</span>
            //           // </p>";
            //       }
            //     }
            //     echo "</div>";
            // }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bottom"></div>
</body>

</html>
<script>
  // Select the edit button
  const editButton = document.querySelector('.js-edit-button');

  // Add a click event listener
  if (editButton) {
    editButton.addEventListener('click', () => {
      Swal.fire({
        title: "Are you sure?",
        text: "Do you want to change your email?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, go to settings!",
        cancelButtonText: "Cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirect to edit settings page
          window.location.href = "../editsettings/";
        }
      });
    });
  }
  
  document.querySelectorAll('.js-count-slots').forEach((element, index) => {
    if (index === 0) {
      element.style.color = 'rgb(196, 196, 196)'
    } else if (index === 1) {
      element.style.color = 'rgb(8, 31, 92)'
    } else {
      element.style.color = 'rgb(245, 81, 80)'
    }
  })
</script>

<!-- carparkingcounter yayni -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Initialize counts
    let totalSlots = 6; // Number of parking spots
    let availableSlots = 0;
    let occupiedSlots = 0;

    function fetchDistance() {
      let statuses = []; // To store the statuses of all parking spots

      // Create an array of AJAX requests
      let requests = [
        $.ajax({
            url: '../../park/car1/data_reader/distance_data.php',
          type: 'GET',
          dataType: 'json'
        }),
        $.ajax({
            url: '../../park/car2/data_reader/distance_data.php',
          type: 'GET',
          dataType: 'json'
        }),
        $.ajax({
            url: '../../park/car3/data_reader/distance_data.php',
          type: 'GET',
          dataType: 'json'
        }),
        $.ajax({
            url: '../../park/car4/data_reader/distance_data.php',
          type: 'GET',
          dataType: 'json'
        }),
        $.ajax({
            url: '../../park/car5/data_reader/distance_data.php',
          type: 'GET',
          dataType: 'json'
        }),
        $.ajax({
            url: '../../park/car6/data_reader/distance_data.php',
          type: 'GET',
          dataType: 'json'
        })
      ];

      // When all requests are done
      $.when.apply($, requests).done(function() {
        // Iterate over each response
        $.each(arguments, function(index, response) {
          // Check if there's an error in the response
          if (response[0].error) {
            $('#distanceContainer').html(response[0].error);
          } else {
            let status = response[0].status;
            statuses.push(status);

            // Update the parking spot icons based on status
            $(`.parking-spot-${index + 1}`).removeClass('available occupied').addClass(status.toLowerCase());
          }
        });

        // Calculate counts
        availableSlots = statuses.filter(status => status === 'Available').length;
        occupiedSlots = statuses.filter(status => status === 'Occupied').length;

        // Update HTML counts
        $('.js-total-slots').text(totalSlots);
        $('.js-available-slots').text(availableSlots);
        $('.js-occupied-slots').text(occupiedSlots);
      });
    }

    fetchDistance(); // Initial call
    setInterval(fetchDistance, 1000); // Repeat every 1 second
  });
</script>

<script>
  function updateClock() {
    var now = new Date();
    var hours = now.getUTCHours() + 8; // Convert to Philippines time (UTC+8)
    var minutes = now.getMinutes();

    // Adjust hours if it's greater than 23 (wrap around)
    if (hours >= 24) {
      hours -= 24;
    }

    // Determine AM or PM
    var period = hours >= 12 ? 'PM' : 'AM';

    // Convert to 12-hour format
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    hours = hours.toString().padStart(2, '0');
    minutes = minutes.toString().padStart(2, '0');

    // Set the time in the format h:i A
    document.getElementById('clock').textContent = hours + ':' + minutes + ' ' + period;
  }

  // Update the clock every minute
  setInterval(updateClock, 60000);

  // Initialize the clock immediately
  window.onload = function() {
    updateClock();
  };
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const logoutButtons = document.querySelectorAll('#logoutBtn, #logoutBtnAlt');

    logoutButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action of the button

        Swal.fire({
          title: 'Are you sure?',
          text: "You will be logged out!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, logout!',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            // Create a FormData object from the form
            const formData = new FormData(document.getElementById('logoutForm'));

            fetch('../logout.php', {
              method: 'POST',
              body: formData
            }).then(response => response.json()).then(data => {
              if (data.status === 'success') {
                window.location.href = '../'; // Redirect after successful logout
              } else {
                Swal.fire('Error', 'Logout failed', 'error');
              }
            }).catch(error => {
              Swal.fire('Error', 'Logout failed', 'error');
            });
          }
        });
      });
    });
  });
</script>