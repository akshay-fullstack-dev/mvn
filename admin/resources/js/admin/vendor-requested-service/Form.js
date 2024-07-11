import AppForm from '../app-components/Form/AppForm';

Vue.component('vendor-requested-service-form', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {
                user_id: '',
                name: '',
                description: '',
                price: '',
                approx_time: '',
                spare_parts: ''

            }
        }
    }

});