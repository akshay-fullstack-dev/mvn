import AppForm from '../app-components/Form/AppForm';

Vue.component('service-category-form', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {
                name: '',
                description: '',
                serviceCategory: ''
            },
            mediaCollections: ['cover', 'gallery', 'pdf', 'video']
        }
    }

});