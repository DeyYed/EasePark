<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
      <a class="cta" href="admin_dashboard.php"><span><image class="icon1" src="icons/dashboard.png"></image>Dashboard</span></a>
      <a class="cta" href="data.php"><span><image class="icon" src="icons/rfid.png"></image>RFID Account</span></a>
      <a class="cta" href="data.php"><span><image class="icon" src="icons/parkingstats.png"></image>Parking Status</span></a>
      <a class="cta" href="parking_logs.php"><span><image class="icon" src="icons/parkinglogs.png"></image>Parking Logs</span></a>
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
                        <div class="inner-count-slots js-count-slots">
                          1
                        </div>
                        <div class="inner-parking-logo">
                          <img src="image/total-parking-slots.png">
                        </div>
                      </div>
                    </div>
                    <div class="available-slots">
                    <p class="total-p-slots">Available Slots</p>
                      <div class="inner-parking-slots">
                        <div class="inner-count-slots js-count-slots">
                          52
                        </div>
                        <div class="inner-parking-logo">
                          <img src="image/available-slots.png">
                        </div>
                      </div>
                    </div>
                    <div class="occupied-slots">
                    <p class="total-p-slots">Occupied Slots</p>
                      <div class="inner-parking-slots">
                        <div class="inner-count-slots js-count-slots">
                          31
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
                  // Define the datetime threshold (e.g., three days ago from now)
                  $dateThreshold = date('Y-m-d H:i:s', strtotime('-10 day')); // Adjust as needed

                  // Prepare SQL query with a WHERE clause to filter by reg_date
                  $stmt = $pdo->prepare("SELECT * FROM rfid_user WHERE reg_date > ?");
                  $stmt->execute([$dateThreshold]);
                  $rows = $stmt->fetchAll();

                  echo "<table class='recently-data-table'>
                          <tr>
                            <th class='table-header'>First Name</th>
                            <th class='table-header'>Last Name</th>
                          </tr>";
                  $index=1;
                  if ($rows) {
                    foreach ($rows as $row) {
                      if ($index % 2 !== 0) {
                      echo "<tr class='table-row'>
                              <td class='padded-cell'>" . htmlspecialchars($row->first_name) . "</td>
                              <td class='padded-cell'>" . htmlspecialchars($row->last_name) . "</td>
                            </tr>";
                      }else{
                      echo "<tr>
                                <td class='padded-cell'>" . htmlspecialchars($row->first_name) . "</td>
                                <td class='padded-cell'>" . htmlspecialchars($row->last_name) . "</td>
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
                <div class="spacing">
                  
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
                  SELECT * FROM parking_logs WHERE time_out IS NOT NULL
                  UNION ALL
                  SELECT * FROM parking_logs WHERE time_in IS NOT NULL
                  ";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $rows = $stmt->fetchAll();
                  
                  echo "<table class='recently-data-table'>
                          <tr>
                            <th class='table-header'>UID</th>
                            <th class='table-header'>Route</th>
                            <th class='table-header'>Time</th>
                          </tr>";
                            
                  $index=1;
                  if($rows) {
                    foreach ($rows as $index => $row) {
                      if ($index % 2 !== 0) {
                        if(isset($row->time_in) && isset($row->time_out)){
                          echo "<tr class='table-row'>
                          <td class='padded-cell'>" . htmlspecialchars($row->rfid_uid) . "</td>
                          <td class='route-exit'>" . "Exit" . "</td>
                          <td class='padded-cell'>" . htmlspecialchars($row->time_out) . "</td>
                         </tr>";
                        }else{
                          echo "<tr class='table-row'>
                          <td class='padded-cell'>" . htmlspecialchars($row->rfid_uid) . "</td>
                          <td class='route-entry'>" . "Entry" . "</td>
                          <td class='padded-cell'>" . htmlspecialchars($row->time_out) . "</td>
                          </tr>";
                        } 
                      }else{
                        if(isset($row->time_in) && isset($row->time_out)){
                          echo "<tr>
                          <td class='padded-cell'>" . htmlspecialchars($row->rfid_uid) . "</td>
                          <td class='route-exit'>" . "Exit" . "</td>
                          <td class='padded-cell'>" . htmlspecialchars($row->time_out) . "</td>
                         </tr>";
                        }else{
                          echo "<tr>
                          <td class='padded-cell'>" . htmlspecialchars($row->rfid_uid) . "</td>
                          <td class='route-entry'>" . "Entry" . "</td>
                          <td class='padded-cell'>" . htmlspecialchars($row->time_out) . "</td>
                          </tr>";
                        } 
                      }
                    }
                  }
                  echo "</table>";
                  ?>
                </div>
              </div>
            </div>
        </div>
    </div>

</body>
</html>
<script>
  document.querySelectorAll('.js-count-slots').forEach((element, index) => {
    if(index === 0){
      element.style.color = 'rgb(196, 196, 196)'
    }else if(index === 1){
      element.style.color = 'rgb(8, 31, 92)'
    }else{
      element.style.color = 'rgb(245, 81, 80)'
    }
  })
</script>
