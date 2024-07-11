class DashboardCommon {
    /* Constructor Method */
    constructor() {
        this.addEventListeners();
    }

    /* Add Event Listeners on click */
    addEventListeners() {
        $(document).off("submit", "#upload-avatar-image", this.uploadAvatarImage);
        $(document).on("submit", "#upload-avatar-image", this.uploadAvatarImage);
        $(document).off("click", ".create-plan-form .create-plan-btn", this.createPlan);
        $(document).on("click", ".create-plan-form .create-plan-btn", this.createPlan);
        $(document).off("click", ".create-plan-form .edit-plan-btn", this.editPlan);
        $(document).on("click", ".create-plan-form .edit-plan-btn", this.editPlan);
        $(document).off("click", '.plus-icon', this.addNewInputField);
        $(document).on("click", '.plus-icon', this.addNewInputField);
        $(document).off("click", '.action .delete-plan', this.deletePlanOpenPopup);
        $(document).on("click", '.action .delete-plan', this.deletePlanOpenPopup);
        $(document).off("click", '.action .delete-avatar', this.deleteImageOpenPopup);
        $(document).on("click", '.action .delete-avatar', this.deleteImageOpenPopup);
        
        $(document).off("click", ".prio-app-close-light-box", this.cancelModal);
        $(document).on("click", ".prio-app-close-light-box", this.cancelModal);

        $(document).off("click", ".planDetails .plan-details-confirm-deacivate-yes", this.deleteConfirmPlanDetail);
        $(document).on("click", ".planDetails .plan-details-confirm-deacivate-yes", this.deleteConfirmPlanDetail);

        $(document).off("click", ".avatarsView .avatar-confirm-delete-yes", this.deleteConfirmAvatarImage);
        $(document).on("click", ".avatarsView .avatar-confirm-delete-yes", this.deleteConfirmAvatarImage);

        $(document).off("click", ".avatarsView .upload-image", this.loadImageUploadView);
        $(document).on("click", ".avatarsView .upload-image", this.loadImageUploadView);
        $(document).off("click", ".service-request-table .service-request-action", this.loadServiceRequestActionPopup);
        $(document).on("click", ".service-request-table .service-request-action", this.loadServiceRequestActionPopup);
        $(document).off("click", ".service-request-add-action-confirm", this.addserviceRequestAction);
        $(document).on("click", ".service-request-add-action-confirm", this.addserviceRequestAction);
        
    }

        /**
     * used to close popup
     *
     * @param element
     */
    openPopup(element) {
        $(element).css("display", "inline-flex");
        $("body").addClass("lightbox-open");
    }

    /**
     * used to close popup
     *
     * @param element
     */
    closePopup(element) {
        $(element).hide();
        $("body").removeClass("lightbox-open");
    }

    /**
     * used to open popup for Delete Plan
     *
     * @param element
     */
    deletePlanOpenPopup(event){
        $(this).closest('.planDetails').find(".plan-details-confirm-deacivate-yes").attr(
            'plan-id',
            $(this).data('plan-id')
        );
        dashboardCommon.openPopup($(this).closest(".planDetails").find(".plan-details-confirm-delete-modal"));
    }

    deleteImageOpenPopup(event){
        $(this).closest('.avatarsView').find(".avatar-confirm-delete-yes").attr(
            'image-id',
            $(this).data('image-id')
        );
        dashboardCommon.openPopup($(this).closest(".avatarsView").find(".avatar-confirm-delete-modal"));
    }

        /**
     * used to Delete Plan
     *
     * @param element
     */
    deleteConfirmPlanDetail(event) {
        let planId = $(this).attr('plan-id');
        if(!planId){
            return false;
        }
        prioHtmlLoader.showLoader($(this),"after");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'/plan-delete',
            data: {"planId": planId},
            success:function(data) {
                prioHtmlLoader.hideLoader($(this));
                prioNotify.success("Plan Deleted Successfully");
                window.location = data.url;
            },
            error: function(data){
                prioHtmlLoader.hideLoader($(this));
                prioNotify.error("Sorry! Something Went Wrong");
                window.location = data.url;
            }
            });

    }
    
    deleteConfirmAvatarImage(event) {
        let defaultAvatarId = $(this).attr('image-id');
        if(!defaultAvatarId){
            return false;
        }
        prioHtmlLoader.showLoader($(this),"after");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'/avatar-delete',
            data: {"avatarId": defaultAvatarId},
            success:function(data) {
                prioHtmlLoader.hideLoader($(this));
                prioNotify.success("Avatar Deleted Successfully");
                window.location = data.url;
            },
            error: function(data){
                prioHtmlLoader.hideLoader($(this));
                prioNotify.error("Sorry! Something Went Wrong");
                window.location = data.url;
            }
            });
    }
    /**
     * cancel Delete modal
     */
    cancelModal() {
        dashboardCommon.closePopup($(this).parents("div.prio-app-lightbox"));
    }

    /**
     * used to add New Input Field for benefits
     * @param element
     */
    addNewInputField(event) {
        event.preventDefault();
        let wrapper = $(".benefits-container");
        $(wrapper).append('<div class="row"><div class="col-md-10"><input type="text" class="form-control" placeholder="Enter Benefit" name="plan_benefits[]" id="plan_benefits[1]" ></div></div>'); //add input box
    }

     /**
     * used to Upload New Image using Ajax
     * @param Image data
     */

    uploadAvatarImage(event) {
        let formElement = $(this).closest('form');
        ImageUploadFormValidation.validateImageUploadForm();
        if (!(formElement.valid())) {
            return false;
        }
        let formData = new FormData(this);
        
        let loaderButton = $(this).find('.image-upload-btn');
        prioHtmlLoader.showLoader($(loaderButton),"after");
        $.ajax({
            type:'POST',
            url:'/avatar-upload',
            data: formData,
            processData: false,
            contentType: false,
            success:function(data) {
                prioHtmlLoader.hideLoader($(loaderButton));  
                window.location.reload();
                prioNotify.success("Avatar Successfully Uploaded");
            }
        });
    }

     /**
     * used to add New add new pLan Data
     * @param FormData
     */
    createPlan( event ) {
        event.preventDefault();
        let formElement = $(this).closest('form');
        CreatePlanFormValidation.validatePlanForm();
        if (!(formElement.valid())) {
            return false;
        }
        prioHtmlLoader.showLoader($(this),"after");
        $.ajax({
            type:'POST',
            url:'/plan-create',
            data:$(formElement).serialize(),
            success:function(data) {
                prioHtmlLoader.hideLoader($(this));
                prioNotify.success("Plan Successfully Created");
                window.location = data.url
            },
            error: function(data){
                prioHtmlLoader.hideLoader($(this));
                prioNotify.error("Sorry! Something Went Wrong");
                window.location = data.url
            }
            });
    }

     /**
     * used to Edit Plan Data
     * @param FormData
     */
    editPlan( event ) {
        event.preventDefault();
        let formElement = $(this).closest('form');
        CreatePlanFormValidation.validatePlanForm();
        if (!(formElement.valid())) {
            return false;
        }
        let planId = $(this).data('plan-id');
        let formData = $(formElement).serialize()
        console.log(formData);
        prioHtmlLoader.showLoader($(this),"after");
        $.ajax({
            type:'POST',
            url:'/plan-update/'+planId,
            data:$(formElement).serialize(),
            success:function(data) {
                prioHtmlLoader.hideLoader($(this));
                prioNotify.success("Plan Successfully Updated");
                window.location = data.url
            },
            error: function(data){
                prioHtmlLoader.hideLoader($(this));
                prioNotify.success("Sorry! Something Went Wrong");
                window.location = data.url
            }
            });
    }

    loadImageUploadView(event) {
        event.preventDefault();
        $.ajax({
            type:'GET',
            url:'/avatar-upload-view',
            success:function(data) {
                if( data.success == true) {
                    $('.avatarsView').html(data.html);
                }else {
                    prioNotify.error(data.msg);
                }
            }
            });
    }

    loadServiceRequestActionPopup(event) {
        $(this).closest('.service-request').find(".service-request-add-action-confirm").attr(
            'request-id',
            $(this).data('request-id')
        );
        dashboardCommon.openPopup($(this).closest(".service-request").find(".service-request-add-action-modal"));
    }

    addserviceRequestAction(event) {
        event.preventDefault();
        let requestId = $(this).attr('request-id');
        let formElement = $(this).closest('form');
        if(!requestId){
            return false;
        }
        ActionRequestFormValidation.validateActionRequestForm();
        if (!(formElement.valid())) {
            return false;
        }
        let action_description = $(formElement).find('.action_description').val();
        console.log(action_description);
        prioHtmlLoader.showLoader($(this),"after");
        let postData = {'requestId': requestId,'FormData': $(formElement).serialize(), 'action_description': action_description};
        $.ajax({
            type:'POST',
            url:'/service-request',
            data:postData,
            success:function(data) {
                prioHtmlLoader.hideLoader($(this));
                window.location = data.url
                prioNotify.success("Request Successfully Updated");
            },
            error: function(data){
                prioHtmlLoader.hideLoader($(this));
                window.location = data.url
                prioNotify.error("Sorry! Something Went Wrong");
            }
            });
    }
}

// Creating Object of class
let dashboardCommon = new DashboardCommon();