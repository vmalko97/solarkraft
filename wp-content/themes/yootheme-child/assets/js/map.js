let autocomplete;
let addressField;


function initAutocomplete() {
    addressField = document.querySelector(".autocomplete_address");
    if(addressField){
        autocomplete = new google.maps.places.Autocomplete(addressField, {
            componentRestrictions: { country: ["se"] },
            fields: ["address_components", "geometry"],
            types: ["address"],
        });
        addressField.focus();
    }
}

