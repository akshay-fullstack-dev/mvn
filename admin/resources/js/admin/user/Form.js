import AppForm from '../app-components/Form/AppForm';

Vue.component('user-form', {
    mixins: [AppForm],
    data: function () {
        return {
            inputs: [{
                doc: '',
                doctype: '',
                city: '',
                country: '',
                formatted_address: '',
                additional_info: '',
                latitude: '',
                longitude: '',
            }],
            form: {
                first_name: '',
                last_name: '',
                email: '',
                email_verified_at: '',
                phone_number: '',
                country_iso_code: '',
                is_blocked: false,
                account_status: false,
                country_code: '',
                created_at: '',
                type: [],
                doc: [],
                doctype: [],
                city: [],
                country: [],
                formatted_address: [],
                additional_info: [],
                latitude: [],
                longitude: [],

            },
            mediaCollections: ['licence', 'education', 'other']
        }
    },
    mounted() {
    },
    updated() {
        var addressLength = this.inputs.length - 1;
        var autocomplete1;
        autocomplete1 = new google.maps.places.Autocomplete(document.getElementById("formatted_address[" + addressLength + "]"), {
            types: ['geocode'],
        });
        google.maps.event.addListener(autocomplete1, 'place_changed', function () {
            var near_place = autocomplete1.getPlace();
            console.log(document.getElementById("latitude[" + addressLength + "]").value);
            document.getElementById("latitude[" + addressLength + "]").value = near_place.geometry.location.lat();
            document.getElementById("longitude[" + addressLength + "]").value = near_place.geometry.location.lng();
            document.getElementById("formatted_address[" + addressLength + "]").value = near_place.formatted_address;

        });
    },
    methods:
    {
        add() {
            
            this.inputs.push({
                doc: '',
                doctype: '',
                type: '',
                city: '',
                country: '',
                formatted_address: '',
                additional_info: '',
                latitude: '',
                longitude: '',
            });
        },
        remove(index) {
            this.inputs.splice(index, 1);
        },
        modifyData: function (event) {
                
            var addressLength = this.inputs.length;
            for(var i=0; i<addressLength ; i++){
                var latitude = document.getElementById("latitude[" + i + "]").value;
                if(typeof latitude != null && latitude !== 'undefined'){
                    this.form.latitude.push({
                        latitude
                    });
                }
                var longitude = document.getElementById("longitude[" + i + "]").value;
                if(typeof longitude != null && longitude !== 'undefined'){
                    this.form.longitude.push({
                        longitude
                    });
                }
                var formatted_address = document.getElementById("formatted_address[" + i + "]").value;
                if(typeof formatted_address != null && formatted_address !== 'undefined'){
                    this.form.formatted_address.push({
                        formatted_address
                    });
                }
            }   
        }
    },
});