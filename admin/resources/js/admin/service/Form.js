import { forEach } from 'lodash';
import AppForm from '../app-components/Form/AppForm';

Vue.component('service-form', {
    mixins: [AppForm],
    data: function () {
        return {
            inputs: [{
                whatsincluded: "",
            }],
            form: {
                name: '',
                description: '',
                serviceCategory: '',
                price: '',
                approx_time: '',
                spare_parts: '',
                whatsincluded: [],
                newwhatsincluded: [],
                dealer_price: '',
                spare_part_price: '',

            },
            mediaCollections: ['cover', 'gallery', 'pdf', 'video']
        }
    },
    methods: {
        modifyData(e) {
            this.form.whatsincluded = this.form.whatsincluded;
            this.form.newwhatsincluded = this.inputs;
        },
        add() {
            if (this.inputs.length < this.form.whatsincluded.length) {
                this.inputs.push({
                    whatsincluded: this.form.whatsincluded[this.inputs.length].name
                });
            }
            else {
                this.inputs.push({
                    whatsincluded: ''
                });
            }

        },
        remove(index) {
            if (this.inputs.length >= 1) {
                this.inputs.splice(index, 1);
                if (this.inputs.length < this.form.whatsincluded.length) {
                    this.form.whatsincluded.pop();
                }
            }
        },

    },
    mounted() {
        console.log(this.form.whatsincluded.length);
        if (this.form.whatsincluded.length == 0) {
            this.inputs.push({
                whatsincluded: ''
            });
        }
        for (let i = 0; i <= this.inputs.length - 1; i++) {
            this.inputs.pop();
        }
        for (let i = 0; i <= this.form.whatsincluded.length - 1; i++) {
            this.inputs.push({
                whatsincluded: this.form.whatsincluded[i].name
            });
        }
    },
});