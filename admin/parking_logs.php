<?php
session_start();
require('../connection.php');
if (!isset($_SESSION["logined"])) {
  header("Location: signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/parking_logs.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="sweetalert2.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

</html>
<body>
  <div class="header">
    <div class="logo-container">
      <img class="cyberpark-logo" src="image/logo1.png">
    </div>
    <div class="name-edit-container">
      <div class="website-name">
        <p>Ease Park</p>
      </div>
    </div>
  </div>
  <div></div>
  <div class="left-dashboard">
    <div class="son-left-dashboard">
      <!-- <a class="son-dashboard" href="admin_dashboard.php">Dashboard</a>
      <div class="son-dashboard">
          Payment
      </div> 
      <a class="son-dashboard" href="data.php">RFID Account</a>
      <a class="son-dashboard" href="data.php">Parking Status</a>
      <a class="son-dashboard" href="parking_logs.php">Parking Logs</a> -->
      <a class="cta" href="admin_dashboard.php"><span>
          <image class="icon1" src="icons/dashboard.png"></image>Dashboard
        </span></a>
      <!-- <div class="son-dashboard">
            Payment
        </div>  -->
      <a class="cta" href="data.php"><span>
          <image class="icon" src="icons/rfid.png"></image>RFID Account
        </span></a>
      <a class="cta" href="parking_status.php"><span>
          <image class="icon" src="icons/parkingstats.png"></image>Parking Status
        </span></a>
      <a class="cta" href="parking_logs.php"><span>
          <image class="icon" src="icons/parkinglogs.png"></image>Parking Logs
        </span></a>
    </div>
    <div class="son-profile">
      <img class="profile-icon" src="icons/Profile.png">
      <p>Admin</p>
      <div class="logout-container">
      <button id="logoutBtn">
            <img class="logout-icon" src="image/logout.png" alt="Logout">
        </button>
        <button class="button-logout" id="logoutBtnAlt">Logout</button>
        <form id="logoutForm" action="logout.php" method="POST" style="display: none;">
            <input type="hidden" name="logout" value="1">
        </form>
      </div>
    </div>
  </div>

  <div class="middle">
    <div class="rfid-account-table">
      <div class="header-table">
        <p class="header-title">Parking Logs</p>
        <div class="search-container">
          <a href="parking_logs.php"><button class="back-button js-search-button">Back</button></a>
          <form class="form" id="search-form" method="GET">
            <button type="submit" name="submitSearch">
              <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </button>
            <input class="input" name="search" placeholder="Search" required type="text">
            <button class="reset" type="reset">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </form>
        </div>
        <div>

        </div>
      </div>
      <table class='data-table'>
        <thead>
          <tr>
            <th>Ticket ID</th>
            <th>UID</th>
            <th>Entry</th>
            <th>Exit</th>
          </tr>
        </thead>
        <tbody id="data-table-body">
          <!-- PAPASOK DITO -->
        </tbody>
      </table>
    </div>
  </div>
  <div class="bottom"></div>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    function fetchData(search = '') {
      $.ajax({
        url: '../admin/logs/fetch_parking_logs.php',
        type: 'GET',
        data: {
          search: search
        },
        success: function(data) {
          $('#data-table-body').html(data);
        }
      });
    }

    setInterval(function() {
      let searchValue = $('input[name="search"]').val();
      fetchData(searchValue);
    }, 1000);
    $('#search-form').submit(function(e) {
      e.preventDefault();
      let searchValue = $('input[name="search"]').val();
      fetchData(searchValue);
    });
    fetchData();
  });
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

            fetch('logout.php', {
              method: 'POST',
              body: formData
            }).then(response => response.json()).then(data => {
              if (data.status === 'success') {
                window.location.href = 'signin.php'; // Redirect after successful logout
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