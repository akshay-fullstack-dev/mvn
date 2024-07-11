import AppForm from '../app-components/Form/AppForm';

Vue.component('app-version-form', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {
                app_package_id: '',
                force_update: false,
                message: '',
                version: '',
                code: '',
                platform: false,

            }
        }
    }

});