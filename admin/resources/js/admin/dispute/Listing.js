import AppListing from '../app-components/Listing/AppListing';

Vue.component('dispute-listing', {
    mixins: [AppListing],
    methods: {
        addDisputeIdInForm(status, dispute_id) {
            document.getElementById("desputeId").value = dispute_id;
            document.getElementById("despute_status").value = status;
        }
    }
});