import AppForm from '../app-components/Form/AppForm';

Vue.component('app-package-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                bundle_id:  '' ,
                app_name:  '' ,
                
            }
        }
    }

});