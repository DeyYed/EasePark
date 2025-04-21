<?php
require('../../connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="../css/landingpage.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <title>Home</title>
  <link rel="icon" href="../landingpage/image/favicon.ico" type="image/x-icon"> 
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
</head>
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
        <a class="cta" href="../landingpage/"><span>Home</span></a>
        <a class="cta" href="../parkingstatus/"><span>Parking Status</span></a>
      </div>
    </div>
  </div>
  
  <div class="content">
    <p class="h1">The Future of Parking is Here.</p>
    <p class="h2">Park Smarter, Not Harder.</p>
    <a class="ctb" href="../parkingstatus/"><span>Check Parking Status</span></a>
  </div>

  <script>
    // Simulate loading delay
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