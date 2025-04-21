<?php
require('../../connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/parking_status.css">
  <link rel="stylesheet" href="../css/parking_status/media.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="sweetalert2.min.css">
</head>
<style>
    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      overflow: hidden; /* Prevent scrolling while loading */
    }
    .loader-container {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      width: 100vw; /* Full width */
      background-color: #e8e8e8; /* Background color */
      position: fixed; /* Keeps loader fixed */
      top: 0;
      left: 0;
      z-index: 1000; /* Ensures it stays on top */
    }
    .loader {
      overflow: visible;
      height: fit-content;
      width: fit-content;
      padding: 20px;
      display: flex;
      box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
      border-radius: 50%;   
      background-image: url('image/v960-ning-03.jpg');
      background-size: cover; /* Adjusts the image to cover the entire element */
      background-position: center; /* Centers the image */
      background-repeat: no-repeat; /* Prevents the image from repeating */
      overflow: hidden; 
      height: 150px;
      width: 150px;
    }
    .loading-logo {
      height:150px;
      width: 150px;
      fill: none;
      stroke-dasharray: 20px;
      stroke: black;
      animation: load 30s infinite linear; /* Increased duration to 30s */
    }
    @keyframes load {
      0% {
        stroke-dashoffset: 0px;
      }
      100% {
        stroke-dashoffset: 350px; /* Adjust based on stroke-dasharray */
      }
    }
  </style>
  
<body>
    <div class="loader-container">
    <div class="loader">
      <svg
        class="loading-logo"
        xmlns="http://www.w3.org/2000/svg"
        width="150"
        height="150"
        viewBox="0 0 31.354 31.354"
      >
        <g>
          <path d="M29.605,18.478l-0.882-7.591h-1.692l-0.078-0.9h3.205v-2.44H26.74l-0.365-4.174H4.98L4.615,7.546H1.226v2.44h3.176
            l-0.079,0.9H2.631L1.75,18.478H0v4.916h2.536v4.588h5.071v-4.588h16.139v4.588h5.072v-4.588h2.535v-4.916H29.605z M6.864,5.427
            H24.49l0.479,5.459H6.385L6.864,5.427z M6,17.173c-1.028,0-1.862-0.833-1.862-1.862c0-1.028,0.834-1.862,1.862-1.862
            c1.029,0,1.862,0.834,1.862,1.862C7.862,16.339,7.029,17.173,6,17.173z M20.92,21.724H10.434v-7.42h10.485L20.92,21.724
            L20.92,21.724z M25.354,17.173c-1.029,0-1.861-0.833-1.861-1.862c0-1.028,0.832-1.862,1.861-1.862c1.028,0,1.862,0.834,1.862,1.862
            C27.216,16.339,26.383,17.173,25.354,17.173z" />
        </g>
      </svg>
    </div>
  </div>
 
  <div class="header">
    <div class="header-son">
      <div class="logo-name-container">
        <div class="logo-container">
          <img class="logo" src="image/logo1.png">
        </div>
        <p>Ease Park</p>
      </div>
      <div class="nav-container">
        <a class="cta" href="landing_page.php"><span>Home</span></a>
        <a class="cta" href="parking_status.php"><span>Parking Status</span></a>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="parking-status">
      <div class="header-table">
        <p class="header-title">Current Parking Status</p>
        <div class="slots-counter">
          <div class="avail-slots">
            <span class="js-available-slots">0</span>
            <span>Available slots</span>
          </div>
          <div class="occu-slots">
            <span class="js-occupied-slots">0</span>
            <span>Occupied slots</span>
          </div>
        </div>
      </div>
      <div class="parking-customization-container">
        <div class="customization-info">
          <img class="park" src="../park/park_image/Desktop_park.png" alt="Parking Lot Customization">
        </div>
        <div class="parking-spot-1">
          <img src="../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
        <div class="parking-spot-2">
          <img src="../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
        <div class="parking-spot-3">
          <img src="../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
        <div class="parking-spot-4">
          <img src="../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
        <div class="parking-spot-5">
          <img src="../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
        <div class="parking-spot-6">
          <img src="../park/park_image/car_park.png" alt="Car Park" class="car-image">
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript Section -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../park/park_javascript/park_car1.js"></script>
  <script src="../park/park_javascript/park_car2.js"></script>
  
  <script>
    $(document).ready(function() {
      let totalSlots = 6;
      let availableSlots = 0;
      let occupiedSlots = 0;

      function fetchDistance() {
        let statuses = [];
        let requests = [
          $.ajax({
            url: '../park/car1/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json'
          }),
          $.ajax({
            url: '../park/car2/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json'
          }),
          $.ajax({
            url: '../park/car3/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json'
          }),
          $.ajax({
            url: '../park/car4/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json'
          }),
          $.ajax({
            url: '../park/car5/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json'
          }),
          $.ajax({
            url: '../park/car6/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json'
          })
        ];
        $.when.apply($, requests).done(function() {
          $.each(arguments, function(index, response) {
            if (response[0].error) {
              $('#distanceContainer').html(response[0].error);
            } else {
              let status = response[0].status;
              statuses.push(status);
              $(`.parking-spot-${index + 1}`).removeClass('available occupied').addClass(status.toLowerCase());
            }
          });
          availableSlots = statuses.filter(status => status === 'Available').length;
          occupiedSlots = statuses.filter(status => status === 'Occupied').length;
          $('.js-total-slots').text(totalSlots);
          $('.js-available-slots').text(availableSlots);
          $('.js-occupied-slots').text(occupiedSlots);
        });
      }

      fetchDistance();
      setInterval(fetchDistance, 1000);
    });
  </script>
  
  <script>
      window.onload = function() {
        setTimeout(function() {
            document.querySelector('.loader-container').style.display = 'none';
            const header = document.querySelector('.header');
            const content = document.querySelector('.content');
            header.style.display = 'block';
            content.style.display = 'flex'; // Changed from 'flex' to 'block'
        }, 3000); // Adjust delay as needed
    };
  </script>
</body>

</html>