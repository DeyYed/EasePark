<!DOCTYPE html>
<html>
<head>
    <title>CyberPark</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #F4FDFF;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .header {
            background-color: #ffffff;
            height: 60px;
            width: calc(100% - 250px); /* Full width minus sidebar width */
            position: fixed;
            top: 0;
            left: 250px; /* Align to the right of the sidebar */
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }
        .sidebar {
            background-color: #ffffff;
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0; /* Start from the top */
            left: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            z-index: 1001;
        }
        .content {
            margin-top: 60px; /* Below the header */
            margin-left: 250px; /* To the right of the sidebar */
            padding: 20px;
            flex: 1;
            overflow-y: auto;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        #carIcon {
            font-size: 100px;
            transition: color 0.5s ease;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            width: 100%;
        }
        .sidebar ul li {
            margin: 10px 0;
            width: 100%;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #000;
            font-weight: regular;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .sidebar ul li a i {
            margin-right: 10px;
        }
        .sidebar ul li a:hover {
            background-color: #f0f0f0;
        }
        .sidebar ul li a.active {
            background-color: #000D18;
            color: #fff;
        }
        .logout {
            margin-top: auto;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            color: red;
        }
        .logout a {
            text-decoration: none;
            color: red;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        .logout a i {
            margin-right: 10px;
        }
        .header h1 {
            margin: 0;
            padding-left: 20px;
        }
        .header img {
            height: 40px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="sidebar">

        <ul>
            <li><a href="#" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-money-bill-wave"></i> Payment</a></li>
            <li><a href="#"><i class="fas fa-id-card"></i> RFID Account</a></li>
            <li><a href="#"><i class="fas fa-parking"></i> Parking Status</a></li>
            <li><a href="#"><i class="fas fa-file-alt"></i> Parking Logs</a></li>
            <li><a href="#"><i class="fas fa-clipboard-list"></i> Attendant Logs</a></li>
        </ul>
        <div class="logout">
            <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    <div class="header">
        <img src="logo.png" alt="CyberPark Logo">
        <h1>CyberPark</h1>
    </div>
    <div class="content">
        <div class="container">
            <h1>Real-Time Distance Display</h1>
            <div id="distanceContainer">
                Loading distance data...
            </div>
            <div id="statusContainer">
                Loading status data...
            </div>
            <i id="carIcon" class="fas fa-car" style="color: gray;"></i>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Function to fetch distance data from the server
            function fetchDistance() {
                $.ajax({
                    url: 'distance_data.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            $('#distanceContainer').html(response.error);
                            $('#statusContainer').html('');
                        } else {
                            // Update the distance container with the latest data
                            $('#distanceContainer').html('Distance: ' + response.distance + ' cm');
                            // Update the status container with the latest status
                            $('#statusContainer').html('Status: ' + response.status);
                            
                            // Change car icon color based on status
                            if (response.status === 'Occupied') {
                                $('#carIcon').css('color', 'red');
                            } else {
                                $('#carIcon').css('color', 'gray');
                            }
                        }
                    },
                    error: function() {
                        $('#distanceContainer').html('Error fetching data');
                        $('#statusContainer').html('Error fetching data');
                    }
                });
            }

            // Fetch distance data initially and then at regular intervals (e.g., every second)
            fetchDistance();
            setInterval(fetchDistance, 1000);
        });
    </script>
</body>
</html>
