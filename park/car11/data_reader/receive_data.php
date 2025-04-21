<?php
// Set maximum execution time to 5 minutes (300 seconds)
ini_set('max_execution_time', 300);

// Open the serial port (adjust the port name based on your Arduino)
$serial = fopen('COM3', 'r'); // On Windows, typically COMx (x is the port number)
// $serial = fopen('/dev/ttyUSB0', 'r'); // On Linux, use /dev/ttyUSBx (x is the port number)
// $serial = fopen('/dev/cu.usbmodem14101', 'r'); // On macOS, use /dev/cu.usbmodemxxx

if ($serial) {
    $timeout = 60; // Timeout in seconds
    $startTime = time(); // Get current time

    while (true) {
        // Read data from the serial port
        $data = fgets($serial);

        // Output "Hello World" once per second
        echo "Hello World<br>";
        flush(); // Flush the output buffer

        // Check if timeout has elapsed
        if (time() - $startTime >= $timeout) {
            echo "Timeout reached. Exiting loop."; // Handle timeout
            break;
        }

        // Delay for 1 second (1000000 microseconds)
        usleep(1000000);
    }

    fclose($serial); // Close the serial port
} else {
    die("Unable to open serial port.");
}
?>
