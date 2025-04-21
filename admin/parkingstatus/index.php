<?php
session_start();
require('../../connection.php');
if (!isset($_SESSION["logined"])) {
  header("Location: ../");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Parking Status</title>
  <link rel="icon" href="../parkingstatus/image/favicon.ico" type="image/x-icon"> 
  <link rel="stylesheet" href="../css/parking_status.css">
  <link rel="stylesheet" href="../css/parking_status/media.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
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
  <div></div>
  <div class="left-dashboard">
    <div class="son-left-dashboard">
      <a class="cta" href="../dashboard/"><span>
          <image class="icon1" src="icons/dashboard.png"></image>Dashboard
        </span></a>
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
    <div class="parking-status">
      <div class="header-table">
        <p class="header-title">Parking Status</p>
      </div>
      <div class="parking-customization-container">
        <div class="customization-info">
          <img class="park" src="../../park/park_image/Desktop_park.png" alt="Parking Lot Customization">
        </div>
        <div class="R-parking-spot-1">
          <img src="../../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
        <div class="R-maintenance-spot-1">
          <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">
        </div>
        <div class="R-parking-spot-2">
          <img src="../../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
        <!--<div class="R-maintenance-spot-2">-->
        <!--  <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">-->
        <!--</div>-->
        <div class="R-parking-spot-3">
          <img src="../../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
        <div class="R-maintenance-spot-3">
          <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">
        </div>
        <div class="R-maintenance-spot-4">
          <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">
        </div>
        <div class="R-maintenance-spot-5">
          <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">
        </div>
        <div class="R-maintenance-spot-6">
          <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">
        </div>
        <div class="L-parking-spot-1">
          <img src="../../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
        <div class="L-maintenance-spot-1">
          <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">
        </div>
        <div class="L-parking-spot-2">
          <img src="../../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
        <div class="L-maintenance-spot-2">
          <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">
        </div>
        <div class="L-parking-spot-3">
          <img src="../../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
        <div class="L-maintenance-spot-3">
          <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">
        </div>
        <div class="L-maintenance-spot-4">
          <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">
        </div>
        <div class="L-maintenance-spot-5">
          <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">
        </div>
        <div class="L-maintenance-spot-6">
          <img src="../../park/park_image/maintenance.png" alt="Maintenance" class="maintenance-image">
        </div>
      </div>
    </div>
  </div>
  <div class="bottom"></div>

  <!-- JavaScript Section -->
  <script src="../parkingstatus/park_car1.js"></script>
  <script src="../../park/park_javascript/park_car2.js"></script>
</body>

</html>
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