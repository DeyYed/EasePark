// Car 1
$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car1/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else {
                    // Update the car icons based on status
                    if (response.status === 'Occupied') {
                        $('.parking-spot-1').removeClass('available').addClass('occupied');
                    } else {
                        $('.parking-spot-1').removeClass('occupied').addClass('available');
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }

    fetchDistance(); // Initial call
    setInterval(fetchDistance, 1000); // Repeat every 1 second
});

// Car 2

$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car2/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else {
                    // Update the car icons based on status
                    if (response.status === 'Occupied') {
                        $('.parking-spot-2').removeClass('available').addClass('occupied');
                    } else {
                        $('.parking-spot-2').removeClass('occupied').addClass('available');
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }

    fetchDistance(); // Initial call
    setInterval(fetchDistance, 1000); // Repeat every 1 second
});

// Car 3

$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car3/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else {
                    // Update the car icons based on status
                    if (response.status === 'Occupied') {
                        $('.parking-spot-3').removeClass('available').addClass('occupied');
                    } else {
                        $('.parking-spot-3').removeClass('occupied').addClass('available');
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }

    fetchDistance(); // Initial call
    setInterval(fetchDistance, 1000); // Repeat every 1 second
});

// Car 4

$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car4/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else {
                    // Update the car icons based on status
                    if (response.status === 'Occupied') {
                        $('.parking-spot-4').removeClass('available').addClass('occupied');
                    } else {
                        $('.parking-spot-4').removeClass('occupied').addClass('available');
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }

    fetchDistance(); // Initial call
    setInterval(fetchDistance, 4000); // Repeat every 1 second
});

// Car 5
$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car5/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else {
                    // Update the car icons based on status
                    if (response.status === 'Occupied') {
                        $('.parking-spot-5').removeClass('available').addClass('occupied');
                    } else {
                        $('.parking-spot-5').removeClass('occupied').addClass('available');
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }

    fetchDistance(); // Initial call
    setInterval(fetchDistance, 1000); // Repeat every 1 second
});

// Car 6
$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car6/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else {
                    // Update the car icons based on status
                    if (response.status === 'Occupied') {
                        $('.parking-spot-6').removeClass('available').addClass('occupied');
                    } else {
                        $('.parking-spot-6').removeClass('occupied').addClass('available');
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }

    fetchDistance(); // Initial call
    setInterval(fetchDistance, 1000); // Repeat every 1 second
});