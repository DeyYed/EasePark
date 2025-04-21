//car 1
$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car1/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else if (response.status === 'Maintenance') {
                    $('.R-maintenance-spot-1').addClass('active');  
                    $('.R-parking-spot-1').removeClass('occupied available');  
                } else {
                    $('.R-maintenance-spot-1').removeClass('active');  
                    if (response.status === 'Occupied') {
                        $('.R-parking-spot-1').removeClass('available').addClass('occupied');  
                    } else {
                        $('.R-parking-spot-1').removeClass('occupied').addClass('available');  
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }
    fetchDistance(); 
    setInterval(fetchDistance, 1000); 
});


//car 2
$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car2/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else if (response.status === 'Maintenance') {
                    $('.R-maintenance-spot-2').addClass('active');  
                    $('.R-parking-spot-2').removeClass('occupied available');  
                } else {
                    $('.R-maintenance-spot-2').removeClass('active');  
                    if (response.status === 'Occupied') {
                        $('.R-parking-spot-2').removeClass('available').addClass('occupied');  
                    } else {
                        $('.R-parking-spot-2').removeClass('occupied').addClass('available');  
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }
    fetchDistance(); 
    setInterval(fetchDistance, 1000); 
});


//car 3
$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car3/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else if (response.status === 'Maintenance') {
                    $('.R-maintenance-spot-3').addClass('active');  
                    $('.R-parking-spot-3').removeClass('occupied available');  
                } else {
                    $('.R-maintenance-spot-3').removeClass('active');  
                    if (response.status === 'Occupied') {
                        $('.R-parking-spot-3').removeClass('available').addClass('occupied');  
                    } else {
                        $('.R-parking-spot-3').removeClass('occupied').addClass('available');  
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }
    fetchDistance(); 
    setInterval(fetchDistance, 1000); 
});


//car 4
$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car4/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else if (response.status === 'Maintenance') {
                    $('.L-maintenance-spot-1').addClass('active');  
                    $('.L-parking-spot-1').removeClass('occupied available');  
                } else {
                    $('.L-maintenance-spot-1').removeClass('active');  
                    if (response.status === 'Occupied') {
                        $('.L-parking-spot-1').removeClass('available').addClass('occupied');  
                    } else {
                        $('.L-parking-spot-1').removeClass('occupied').addClass('available');  
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }
    fetchDistance(); 
    setInterval(fetchDistance, 1000); 
});

//car 5
$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car5/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else if (response.status === 'Maintenance') {
                    $('.L-maintenance-spot-2').addClass('active');  
                    $('.L-parking-spot-2').removeClass('occupied available');  
                } else {
                    $('.L-maintenance-spot-2').removeClass('active');  
                    if (response.status === 'Occupied') {
                        $('.L-parking-spot-2').removeClass('available').addClass('occupied');  
                    } else {
                        $('.L-parking-spot-2').removeClass('occupied').addClass('available');  
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }
    fetchDistance(); 
    setInterval(fetchDistance, 1000); 
});


//car 6
$(document).ready(function() {
    function fetchDistance() {
        $.ajax({
            url: '../park/car6/data_reader/distance_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#distanceContainer').html(response.error);
                } else if (response.status === 'Maintenance') {
                    $('.L-maintenance-spot-3').addClass('active');  
                    $('.L-parking-spot-3').removeClass('occupied available');  
                } else {
                    $('.L-maintenance-spot-3').removeClass('active');  
                    if (response.status === 'Occupied') {
                        $('.L-parking-spot-3').removeClass('available').addClass('occupied');  
                    } else {
                        $('.L-parking-spot-3').removeClass('occupied').addClass('available');  
                    }
                }
            },
            error: function() {
                $('#distanceContainer').html('Error fetching data');
            }
        });
    }
    fetchDistance(); 
    setInterval(fetchDistance, 1000); 
});
