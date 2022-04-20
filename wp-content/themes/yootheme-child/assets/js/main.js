$(document).ready(function() {

    $('#solar_order').submit(function(e){
        var data = $(this).serialize();
        e.preventDefault();
        $.post(
            wp_ajax.url,
            data,
            function (response) {
                console.log(response);
                $('#map').hide();
            })
    });

});