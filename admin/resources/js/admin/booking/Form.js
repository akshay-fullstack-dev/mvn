import AppForm from '../app-components/Form/AppForm';

Vue.component('booking-form', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {
                order_id: '',
                user_id: '',
                vendor_id: '',
                service_id: '',
                address_id: '',
                payment_id: '',
                package_id: '',
                vehicle_id: '',
                booking_start_time: '',
                booking_end_time: '',
                booking_status: false,
                booking_type: false,
                addition_info: '',
            },

        }
    },
    methods:
    {
        changeFunction() {
            console.log("hello");
        }
    }

});