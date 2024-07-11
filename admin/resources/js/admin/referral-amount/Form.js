import AppForm from '../app-components/Form/AppForm';

Vue.component('referral-amount-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                referral_amount:  '' ,
                
            }
        }
    }

});