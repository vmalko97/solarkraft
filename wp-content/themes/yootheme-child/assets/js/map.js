let autocomplete;
let addressField;


function initAutocomplete() {
    addressField = document.querySelector(".autocomplete_address");

    console.log("GM_AC_ON");
    if(addressField){
        autocomplete = new google.maps.places.Autocomplete(address1Field, {
            componentRestrictions: { country: ["au"] },
            fields: ["address_components", "geometry"],
            types: ["address"],
        });
        addressField.focus();
    }
    if(autocomplete){
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
     //   autocomplete.addListener("place_changed", fillInAddress);
    }

}

