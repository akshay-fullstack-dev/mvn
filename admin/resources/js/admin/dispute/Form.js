import AppForm from '../app-components/Form/AppForm';

Vue.component('dispute-form', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {
                booking_id: '',
                user_id: '',
                message: '',
                is_resolved: false,
                booking: [],
                responsed_message: '',
                responsed_at: '',

            }
        }
    },
    methods: {
        showMessagePopModel() {
            alert("hello");
        }
    }

});