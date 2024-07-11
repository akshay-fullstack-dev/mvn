import AppForm from '../app-components/Form/AppForm';

Vue.component('delivery-charge-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                customer_delivery_charge:  '' ,
                vendor_delivery_charge:  '' ,
                
            }
        }
    }

});