import AppForm from '../app-components/Form/AppForm';

Vue.component('user-document-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                user_id:  '' ,
                document_name:  '' ,
                document_number:  '' ,
                front_image:  '' ,
                back_image:  '' ,
                document_type:  false ,
                document_status:  false ,
                message:  '' ,
                
            }
        }
    }

});