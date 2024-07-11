$(document).on('click', '.delete-popup' function() {
    $(".foco-sign-up-frm").trigger('reset');
    $(".foco-sign-in-frm").trigger('reset');
    $('#signIn').modal('open'); 
    $('#success-modal').modal('close'); 
});

$(document).on('click', '.foco-signin-signup', function() {
    var that = this;
    var activeRequest = $(that).closest(".foco-signIn-Up").find(".active").attr('href');
    if ( activeRequest == "#foco-sign-in-request" ) {
        var activeRequestForm = getFormClassName(activeRequest);
        signInRequest(activeRequestForm);
    }
    else {
        var activeRequestForm = getFormClassName(activeRequest);
        signUpRequest(activeRequestForm);
    }
});

function getFormClassName ( formHrefAttribute) {
    return formHrefAttribute.slice(1);
}

function signInRequest( activeRequestForm ) {
    var formElement = $(".focco-main-wrapper").find('.foco-sign-in-frm');
    SignInFormValidation.validateSignInForm();
    if(!formElement.valid()){
        return false;
    }
    var userEmail = $(formElement).find('.sign_in_email').val();
    var userPassword = $(formElement).find('.sign_in_password').val();

    var postData = {"email" : userEmail, "password" : userPassword};
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/userLogin',
        data : postData,
        success : function ( data ) {
            if(data.response.error){
                toastr.error(data.response.error);
            }else{
                $('#signIn').modal("close");
                $('#success-login').modal("open");
                setTimeout(function(){
                    window.location.href = $('#baseUrl').val()+"/dashboard";
                },300);
            }
        },
        error: function (textStatus, errorThrown) {
            console.log(errorThrown);
        }

     });
}
function signUpRequest( activeRequestForm ) {
    var formElement = $(".focco-main-wrapper").find('.foco-sign-up-frm');
    FormValidation.validateSignUpForm();
    if(!formElement.valid()){
        return false;
    }
    var country_code = $("#foco_mobile").intlTelInput("getSelectedCountryData").dialCode;
    
    var postData = $(formElement).serialize();
    var formData = postData.concat('&country_code='+country_code);
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/userRegister',
        data : formData,
        success : function ( data ) {
            if(data.response.error){
                toastr.error(data.response.error);
            }else{
                $('#signIn').modal("close");
                $('#forgotType').val(0);
                $("#verification").modal("open");
                $('.code').val('');
                var foco_mobile = $('#foco_mobile').val();
                var first_digit = foco_mobile.substring(0, 2);
                var last_digit = parseInt(foco_mobile % 100);
                
                $('.user_phone').html('+'+country_code + ' ' + first_digit + 'XXXXXX'+last_digit);
                
                localStorage.setItem("country_code", country_code);
                localStorage.setItem("user_phone", foco_mobile);
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
}

$(document).on('click', '.verify_otp', function() {
    var formElement = $(".focco-main-wrapper").find('.verification_otp');
    
    var proceed = true;

    $.each($('input.code'),function() {
        // if ($(this).val().length == $(this).maxLength) {
            $(this).next('input.code').focus();
        // }
    });

    var OTP1 = $('.code1').val();
    var OTP2 = $('.code2').val();
    var OTP3 = $('.code3').val();
    var OTP4 = $('.code4').val();
    var OTP5 = $('.code5').val();
    var OTP6 = $('.code6').val();
    var otp = OTP1.toString() + OTP2.toString() + OTP3.toString() + OTP4.toString() + OTP5.toString() + OTP6.toString();
    console.log(otp);
    if (otp.length != 6 || otp == null) {
        formElement.find('span.error').css('display', 'block');
        proceed = false;
        return false;
    }
    if(proceed === false){
        return false;
    }
    var postData = $(formElement).serialize();
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/verifyOTP',
        data : postData,
        success : function ( data ) {
            if(data.response.error){
                toastr.error(data.response.error);
            }else{
                toastr.success('OTP verified');
                $('#verification').modal("close");
                if($('#forgotType').val() == 1){
                    $("#verification").modal("close");
                    $("#createPassword").modal("open");
                }else{
                    window.location.href = $('#baseUrl').val()+"/dashboard";
                }
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
});

$(document).on('click', '#resend-code', function() {

    var formElement = $(".focco-main-wrapper").find('.verification_otp');

    var postData = $(formElement).serialize();
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/resendOTP',
        data : {country_code: localStorage.getItem("country_code"),phone:localStorage.getItem("user_phone")},
        success : function ( data ) {
            if(data.response.error){
            }else{
                localStorage.removeItem("country_code");
                localStorage.removeItem("user_phone");
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
     return false;
});

$(document).on('click', '.logout', function() {
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/logout',
        data : {},
        success : function ( response ) {
            if(response.success){
                toastr.success(response.message);
                localStorage.setItem("openPopup", true);
                window.location.href = $('#baseUrl').val();
            }
        },
        error: function (textStatus, errorThrown) {
            console.log(errorThrown);
        }

     });
});

$(document).on('click', '.foco-forgot-passowrd', function() {
    $('#signIn').modal('close');
    $(".foco-forgot-pass-frm").trigger('reset');
    $('#forgotPassword').modal('open');
});

$(document).on('click', '#forgotsubmit', function() {
    if ($.trim($("#phone").val()) == "") 
    {
        $('.error_msg').html('Please enter phone number');
        $('.error_msg').removeClass('hide');      
        return false;
    }else if (!$("#phone").intlTelInput("isValidNumber")){
        $('.error_msg').html('The number is invalid');
        $('.error_msg').removeClass('hide');
        return false;
    }
  
    var country_code = $("#phone").intlTelInput("getSelectedCountryData").dialCode;
    var formElement = $(".focco-main-wrapper").find('.foco-forgot-pass-frm');
    var postData = $(formElement).serialize();
    var formData = postData.concat('&country_code='+country_code);

    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/forgotPassword',
        data : formData,
        success : function (data) {
           if(data.response.error){
               toastr.error(data.response.error);
            }else{
                toastr.success(data.response.message);
                $('#forgotPassword').modal("close");
                $('#forgotType').val(1);
                $("#verification").modal("open");
                $('.code').val('');
                var foco_mobile = $('#phone').val();
                var first_digit = foco_mobile.substring(0, 2);
                var last_digit = parseInt(foco_mobile % 100);
                
                $('.user_phone').html('+'+country_code + ' ' + first_digit + 'XXXXXX'+last_digit);
                
                localStorage.setItem("country_code", country_code);
                localStorage.setItem("user_phone", foco_mobile);
                
            }
        },
        error: function (textStatus, errorThrown) {
            console.log(errorThrown);
        }
    }); 
});

$(document).on('click', '#changeCurrentPass', function() {
    var formElement = $(".focco-main-wrapper").find('.foco-change-password-form');
    FormValidation.ChangePasswordValidation();
    if(!formElement.valid()){
        return false;
    }
    
    var postData = $(formElement).serialize();
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/changePassword',
        data : postData,
        success : function ( data ) {
            if(data.response.error){
                toastr.error(data.response.error);
                
            }else{
            toastr.success(data.response.response);    
                $('#changePassword').modal("close");
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
});

$(document).on('blur', '#phone', function() {
    var telInput = $("#phone");
    if ($.trim(telInput.val())) 
    {
        if (telInput.intlTelInput("isValidNumber")) 
        {
            $('.error_msg').html('');
            $('.error_msg').addClass('hide');
        }
        else{
            $('.error_msg').html('The number is invalid');
            $('.error_msg').removeClass('hide');
        }
    }
});

$(document).on('click', '.changepass', function() {
    $('#changePassword').modal('open'); 
    $('#logout-popup').modal('close'); 
});

$(document).on('click', '#createNewPass', function() {
    var formElement = $(".focco-main-wrapper").find('.foco-forgot-password-form');
    FormValidation.CreatePasswordValidation();
    if(!formElement.valid()){
        return false;
    }
    
    var postData = $(formElement).serialize();
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/changeForgotPassword',
        data : postData,
        success : function ( data ) {
            if(data.response.error){
                toastr.error(data.response.error);
            }else{
                toastr.success(data.response.success);
                $('#createPassword').modal("close");
                $("#success-modal").modal("open");
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
});

$(document).on('click', '#update-profile', function() {
    var formElement = $(".focco-main-wrapper").find('.foco-user-profile-form');
    FormValidation.validateUpdateUserForm();
    if(!formElement.valid()){
        return false;
    }  
    
    var postData = $(formElement).serialize();
    
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/updateUser',
        data : postData,
        success : function ( data ) {
            if(data.response.error){
                toastr.error(data.response.error);
            }else{
                toastr.success(data.response.message);
                $('.user-icon.modal-trigger').find('span').html($('.user_name').val());
                $('.old_email').val($('.user_email').val());
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
});


$(document).on('click', '#save-card', function() {
    var formElement = $(".focco-main-wrapper").find('.save-card-form');    
    FormValidation.validateAddCardForm();
    if(!formElement.valid()){
        return false;
    }  
    
    var postData = $(formElement).serialize();

    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/addCard',
        data : postData,
        success : function ( data ) {
            if(data.response.error){
                toastr.error(data.response.error);
            }else{
                toastr.success(data.response.message);
                $('#save-card').parents('#card-form').addClass('hide');
                $('#card-details-form').removeClass('hide');
                var card_number = $('#ccn').val();
                var last_digits = parseInt(card_number)%10000;
                $('p.card-no').html('xxxx-xxxx-xxxx-'+last_digits);
                $('#expiry_detail').val($('#valid_date').val());
                $('#holder_name').val($('#card-holder').val());
                $('#cvv_no').val($('#CVV').val());
                $('#continue-payment-process').attr('data-cardId',data.response.card_id);
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
});

function getCards(){
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/getCards',
        data : {},
        success : function ( data ) {
            if(data.response.error){
                toastr.error(data.response.error);
            }else{
//                if(typeof data.response.cardsListing != 'undefined'){
//                    $('.card-listing-div').html(data.response.cardsListing);
//                }
                $('#save-card').parents('#card-form').addClass('hide');
                $('#save-card').parents('#card-form').next().removeClass('hide');
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
}

$(document).on('click', '.card-selection', function() {
    $(this).parents('#available-method').addClass('hide');
    $('#card-details-form').removeClass('hide');
    $('#continue-payment-process').attr('data-cardId',$(this).attr('data-cardId'));
});

$(document).on('click', '#continue-payment-process', function() {
    var coupon_id = $('.detail_coupon_title').attr('data-id');
    var postData = {};
    postData.card_id = $(this).attr('data-cardId');
    postData.amount = 20;
    postData.coupon_id = coupon_id;
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/continuePaymentProcess',
        data : postData,
        success : function ( data ) {
            if(data.response.error){
                toastr.error(data.response.error);
            }else{
                toastr.success(data.response.message);
//                window.location.href = $('#baseUrl').val()+'/purchaseDetails/'+coupon_id;
                $('#paymentSuccess').modal('open');
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
});

$(document).on('keypress change', '#ccn', function() {    
  $(this).val(function (index, value) {
      if(value.length >= 19){
          return value;
      }
    return value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
  });  
});

$(document).on('click','#filter-coupons',function(){
    
    var featured = ($('.featuredfilter').is(':checked')) ? '1' : '0';
    var topRated = ($('.topRateFilter').is(':checked')) ? '1' : '0';
    var price1 = $( "input[name=range-1]" ).val();
    var price2 = $( "input[name=range-2]" ).val();
    
    var url = $('#baseUrl').val()+'/filteredCoupons?topRated='+topRated+'&price_range[]='+price1+'&price_range[]='+price2;
    if(featured == 1){
        url = url + '&featured='+featured ;
    }
    
    window.location.href= url;
});

$(document).on('click', '.successful-payment-redeem-coupon', function() {   
    if($(this).hasClass('not-active')){
        return false;
    }
    var coupon_id = $(this).data('coupon-id');
    if(!coupon_id){
        return false;
    }
    var postData = {};
    postData.coupon_id = coupon_id;
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/redeemCouponAfterPayment',
        data : postData,
        success : function ( data ) {
            console.log(data);
            if(data.response.message){
                toastr.success(data.response.message);
                var coupon = data.response.coupon;
                $('.successful-payment-redeem-coupon').closest('.coupon-code-desc').find('#coupan-code-section').html(coupon.coupon_code);
                if($('.successful-payment-redeem-coupon').closest('.coupon-code-desc').find('#coupan-code-section').hasClass('coupon-code-blur')) {
                    $('.successful-payment-redeem-coupon').closest('.coupon-code-desc').find('#coupan-code-section').removeClass('coupon-code-blur');
                }
                if($('.successful-payment-redeem-coupon').hasClass('active')){
                    $('.successful-payment-redeem-coupon').removeClass('active');
                    $('.successful-payment-redeem-coupon').addClass('not-active');
                }

            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });

});

$(document).on('click', '.notification-icon',function(){
    $.ajax({
        type : 'Get',
        url : $('#baseUrl').val()+'/userNotifications',
        success : function ( data ) {
            if(data.response.returnhtml){
                var html = data.response.returnhtml;
                $('.notification-icon').after(html);
                $('#notification-modal').modal();
                $('#notification-modal').modal("open");
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
});

$(document).on('click', '.notification-mark-as-read', function(){
var notificationTray = $(this).closest('.notification-list-inner');
var id = $(notificationTray).data('id');
    $.ajax({
        type : 'POST',
        url : $('#baseUrl').val()+'/updateNotification',
        data : {'id': id},
        success : function ( data ) {
            if(data.response.message){
                window.location.reload();
                toastr.success(data.response.message);
            }
        },
        error: function (textStatus, errorThrown) {
        console.log(errorThrown);
        }
    });
});

$(document).on('click', '.purchase-heading .my-redeemed-list', function(){
    $.ajax({
        type : 'Get',
        url : $('#baseUrl').val()+'/getRedeemedCoupons',
        success : function ( data ) {
            if(data.response.returnHtml){
                var html = data.response.returnHtml;
                if($('.my-purcheses-list').hasClass('active')){
                    $('.my-purcheses-list').removeClass('active')
                    $('.my-redeemed-list').addClass('active');
                }
                
                $('.coupon-listing').html('');
                $('.coupon-listing').html(html);
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
     
});
$(document).on('click', '.purchase-heading .my-purcheses-list', function(){
    $.ajax({
        type : 'Get',
        url : $('#baseUrl').val()+'/getMyPurchaselist',
        success : function ( data ) {
            if(data.response.returnHtml){
                var html = data.response.returnHtml;
                if($('.my-redeemed-list').hasClass('active')){
                    $('.my-redeemed-list').removeClass('active')
                    $('.my-purcheses-list').addClass('active');
                }
                
                $('.coupon-listing').html('');
                $('.coupon-listing').html(html);
            }
        },
        error: function (textStatus, errorThrown) {
           console.log(errorThrown);
        }

     });
});

function initialize() {
       var input = document.getElementById('search');
       var autocomplete = new google.maps.places.Autocomplete(input);
       autocomplete.addListener('place_changed', function() {
           var place = autocomplete.getPlace();
           var latitude = $('#latitude').val(place.geometry['location'].lat());
           var longitude = $('#longitude').val(place.geometry['location'].lng());
           console.log($(latitude).val());
           console.log($(longitude).val());
        //    $("#lat_area").removeClass("d-none");
        //    $("#long_area").removeClass("d-none");
       });
   }