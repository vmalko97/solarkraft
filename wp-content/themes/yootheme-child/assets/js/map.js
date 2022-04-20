let autocomplete;
let addressField;
let marker;
let map;

function initGMap() {
    initAutocomplete();
    initMap();
}

function initMap() {
     map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: {lat: 0, lng: 0},
        disableDefaultUI: true,
        mapTypeId: 'satellite'
    });

    marker = new google.maps.Marker({
        map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: {lat: 0, lng: 0},
    });
    marker.addListener("click", toggleBounce);
    marker.addListener("dragend", function () {
        let lat = marker.getPosition().lat();
        let lng = marker.getPosition().lng();
        console.log(lat);
        console.log(lng);
        $('input[name="longitude"]').val(lng);
        $('input[name="latitude"]').val(lat);
    });
}

function toggleBounce() {
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}

//window.initMap = initMap;

function initAutocomplete() {
    addressField = document.querySelector(".autocomplete_address");
    if (addressField) {
        autocomplete = new google.maps.places.Autocomplete(addressField, {
            componentRestrictions: {country: ["se"]},
            fields: ["address_components", "geometry"],
            types: ["address"],
        });
        addressField.focus();
    }
}

$(document).ready(function () {
    $('.init_marker').on('click', function () {
        var address = $('.autocomplete_address').val();
        $.post(
            wp_ajax.url,
            {
                action: 'google_geocoding',
                request: address,
            },
            function (response) {
                response = JSON.parse(response);
                map.setCenter({lat: response.latitude, lng: response.longitude});
                map.setZoom(20);
                marker.setPosition({lat: response.latitude, lng: response.longitude});
                $('input[name="address"]').val(address);
                $('input[name="longitude"]').val(response.longitude);
                $('input[name="latitude"]').val(response.latitude);
            });
        $('.address-form').hide();
        $('#map').show();
        $('.submit-order').show();
    });
});

