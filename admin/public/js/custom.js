function createVendorListHtml(data) {
  var html = "<option selected>Select the vendor</option>";
  data.forEach(element => {
    html += `<option value=${element.id}>${element.first_name} ${element.email}</option>`;
  });
  return html;
}

function add_vendor(obj) {
  var url = obj.getAttribute('data-url');
  var booking_id = obj.getAttribute('data-id');
  var order_id = obj.getAttribute('data-order-id');
  var vendor_id = obj.getAttribute('data-vendor-id');

  if (vendor_id) {
    return false;
  }

  axios.get(url)
    .then(function (response) {
      if (response.data.length > 0) {
        document.getElementById('booking-order-id').innerHTML = order_id;
        document.getElementById("assign-vendor-submit").disabled = false;
        document.getElementById("vendor-booking-id").value = booking_id;
        document.getElementById("vendor-order-id").value = order_id;
        document.getElementById('vendor-select').innerHTML = createVendorListHtml(response.data);
        $("#exampleModal").modal();
      } else {
        document.getElementById('vendor-select').innerHTML = '<option>Vendor not found.</option>';
        document.getElementById("assign-vendor-submit").disabled = true;
        $("#exampleModal").modal();
      }
    })
    .catch(function (error) {
      document.getElementById('vendor-select').innerHTML = '<option>Vendor not found.</option>';
      document.getElementById("assign-vendor-submit").disabled = true;
      $("#exampleModal").modal();
    });
}