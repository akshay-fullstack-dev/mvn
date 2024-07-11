import AppForm from '../app-components/Form/AppForm';

Vue.component('spare-parts-shop-location-form', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {
                shop_name: '',
                additional_shop_information: '',
                country: '',
                formatted_address: '',
                city: '',
                postal_code: '',
                lat: '',
                long: '',
            }
        }
    },
    methods: {
        addAddress() {
            var form = this.form;
            var autocomplete = new google.maps.places.Autocomplete(document.getElementById("formatted_address"));
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var near_place = autocomplete.getPlace();
                near_place.address_components.map(function (data) {
                    if (data.types[0] == 'country') {
                        form.country = data.long_name;
                    }
                    if (data.types[0] == 'postal_code') {
                        form.postal_code = data.long_name;
                    }
                    if (data.types[0] == 'locality') {
                        form.city = data.long_name;
                    }
                    form.formatted_address = near_place.formatted_address;
                    form.lat = near_place.geometry.location.lat();
                    form.long = near_place.geometry.location.lng();
                });
            });


        }
    }

});