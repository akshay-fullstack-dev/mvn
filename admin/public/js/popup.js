// $(document).on('click', '.delete-popup' ,function() 
// {
//         $(".delete-modal").css("display", "inline-flex");
//         $("body").addClass("lightbox-open");	 
// });

function addDisputeIdInForm(status, dispute_id) {
  console.log(status);
  console.log(dispute_id);
  // var k = a.getAttribute("for");

  // document.getElementById("userId").value = k;

}
function myFunction(a) {
  var k = a.getAttribute("for");
  document.getElementById("userId").value = k;

}
function validateRejectForm() {
  var x = document.forms["reason_form"]["reason"].value;
  if (x == "") {
    alert("Reason must be filled out");
    return false;
  }
}
function validateReasonForm() {
  var x = document.forms["reason_form"]["reason"].value;
  if (x == "") {
    alert("Reason must be filled out");
    return false;
  }
}
function approveService(a) {
  var id = a.getAttribute("for");
  var suserId = a.getAttribute("id");
  document.getElementById("serviceId").value = id;
  document.getElementById("sUserId").value = suserId;
  //alert("Reason must be filled out");
}
function disapproveService(a) {
  var id = a.getAttribute("for");
  var suserId = a.getAttribute("id");
  document.getElementById("dis_serviceId").value = id;
  document.getElementById("disapproveUserId").value = suserId;
  //alert("Reason must be filled out");
}
function validateDisapproveForm() {
  var x = document.forms["reason_form"]["reason"].value;
  if (x == "") {
    alert("Reason must be filled out");
    return false;
  }
}
