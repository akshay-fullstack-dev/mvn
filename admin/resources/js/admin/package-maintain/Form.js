import AppForm from '../app-components/Form/AppForm';

Vue.component('package-maintain-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                package_id:  '' ,
                user_id:  '' ,
                order_id:  '' ,
                transaction_id:  '' ,
                amount:  '' ,
                
            }
        }
    }

});