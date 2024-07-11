import AppForm from '../app-components/Form/AppForm';

Vue.component('coupon-form', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {
                coupon_code: '',
                coupon_discount: '',
                coupon_max_amount: '',
                coupon_min_amount: '',
                coupon_name: '',
                coupon_type: false,
                end_date: '',
                maximum_per_customer_use: '',
                maximum_total_use: '',
                start_date: '',
                users_id: '',

            }
        }
    }

});
