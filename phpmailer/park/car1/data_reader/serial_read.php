<?php
// Define the COM port of your Arduino (Windows)
$comPort = 'COM3'; // Adjust this according to your Arduino's COM port

// Attempt to open the serial port
$serial = @fopen($comPort, 'r+'); // Use @ to suppress warning

if (!$serial) {
    die('Error: Unable to open COM port. Make sure it is not in use and permissions are set correctly.');
}

// Wait for Arduino to send data
sleep(2); // Wait for 2 seconds to ensure Arduino has sent data

// Read data from the serial port (Arduino)
$data = fgets($serial);

// Close the serial port
fclose($serial);

// Display the received data
echo "Arduino says: " . $data;
?>