import AppForm from '../app-components/Form/AppForm';

Vue.component('package-form', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {
                name: '',
                description: '',
                status: false,
                booking_gap: '',
                start_date: '',
                end_date: '',
                no_of_times: '',
                dealer_price: '',
                normal_price: '',
                available_service: [],
                selected_service: [],
                change_service_url: '',
                sparepartdescription:''
            },
            mediaCollections: ['cover', 'gallery', 'pdf', 'video']
        }
    },
    methods: {
        onSelectServiceChange: function (service) {
            // get new services
            this.form.selected_service.push(service);
            axios.post(this.form.change_service_url + '/filter_services', {
                selected_service: this.form.selected_service
            }).then(response => {
                // console.log(response.data)
                if (response.data) {
                    this.form.available_service = response.data;
                }
            })
                .catch(error => {
                    alert('service not found.')
                })
        },
        removeSelectedService: function (index) {
            this.form.selected_service.splice(index, 1);
            axios.post(this.form.change_service_url + '/filter_services', {
                selected_service: this.form.selected_service
            }).then(response => {
                if (response.data) {
                    this.form.available_service = response.data;
                }
            }).catch(error => {
                alert('service not found.')
            })
        }
    }

});