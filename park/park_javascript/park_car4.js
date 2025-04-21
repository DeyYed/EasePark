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