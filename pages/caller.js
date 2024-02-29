// Vehicle Owner display
$(document).ready(function () {
  $("#vehicle_no").change(function () {
    var selectedVehicle = $(this).val();
    $.ajax({
      url: "pages/fetch_vehicle_owner.php",
      type: "post",
      data: { vehicle_number: selectedVehicle },
      dataType: "json",
      success: function (response) {
        $("#vehicle_owner").val(response.owner);
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });
  });
});

// Bill Freight Calculation

$(document).ready(function () {
  // Add input event listener to the loading weight and party rate inputs
  $("#loading_wt, #party_rate").on("input", function () {
    var loadingWeight = parseFloat($("#loading_wt").val());
    var partyRate = parseFloat($("#party_rate").val());

    // Calculate the bill freight
    var billFreight = loadingWeight * partyRate;

    // Set the calculated bill freight value to the input field
    $("#bill_freight, #bill_balance_amount").val(
      isNaN(billFreight) ? "" : billFreight.toFixed(2)
    );
  });
});

// Vehicle Freight Calculation
$(document).ready(function () {
  $("#unload_wt, #transporter_rate").on("input", function () {
    var unloadWeight = parseFloat($("#unload_wt").val());
    var transporterRate = parseFloat($("#transporter_rate").val());

    // Calculate the vehicle freight
    var vehicleFreight = unloadWeight * transporterRate;

    // Set the calculated vehicle freight value to the input field
    $("#vehicle_freight, #statement_balance_amount").val(
      isNaN(vehicleFreight) ? "" : vehicleFreight.toFixed(2)
    );
  });
});
$(document).ready(function () {
  // Function to fetch and populate consignor names in the select dropdown
  function fetchConsignorNames() {
    $.ajax({
      type: "GET",
      url: "fetch_consignor_names.php", // PHP script to fetch consignor names
      dataType: "json",
      success: function (response) {
        // Populate the select dropdown with consignor names
        $("#consignor_select")
          .empty()
          .append('<option value="">Select Consignor</option>');
        $.each(response, function (index, consignor) {
          $("#consignor_select").append(
            '<option value="' +
              consignor.name +
              '">' +
              consignor.name +
              "</option>"
          );
        });
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });
  }

  // Function to fetch and populate consignor details
  function fetchConsignorDetails(consignorName) {
    $.ajax({
      type: "POST",
      url: "fetch_consignor_details.php", // PHP script to fetch consignor details
      data: { consignor_name: consignorName },
      dataType: "json",
      success: function (response) {
        // Populate the input fields with the fetched details
        $("#consignor_name").val(response.Consignor_name);
        $("#consignor_mobile").val(response.Consignor_mobile);
        $("#consignor_gstin").val(response.Consignor_gstin);
        $("#consignor_email").val(response.Consignor_email);
        $("#consignor_address").val(response.Consignor_address);
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });
  }

  // Event listener for consignor select dropdown change
  $("#consignor_select").on("change", function () {
    var consignorName = $(this).val();
    if (consignorName !== "") {
      fetchConsignorDetails(consignorName);
    }
  });

  // Fetch consignor names when the page loads
  fetchConsignorNames();

  // Function to fetch and populate consignee names in the select dropdown
  function fetchConsigneeNames() {
    $.ajax({
      type: "GET",
      url: "fetch_consignee_names.php", // PHP script to fetch consignee names
      dataType: "json",
      success: function (response) {
        // Populate the select dropdown with consignee names
        $("#consignee_select")
          .empty()
          .append('<option value="">Select Consignee</option>');
        $.each(response, function (index, consignee) {
          $("#consignee_select").append(
            '<option value="' +
              consignee.name +
              '">' +
              consignee.name +
              "</option>"
          );
        });
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });
  }

  // Function to fetch and populate consignee details
  function fetchConsigneeDetails(consigneeName) {
    $.ajax({
      type: "POST",
      url: "fetch_consignee_details.php", // PHP script to fetch consignee details
      data: { consignee_name: consigneeName },
      dataType: "json",
      success: function (response) {
        // Populate the input fields with the fetched details
        $("#consignee_name").val(response.Consignee_name);
        $("#consignee_mobile").val(response.Consignee_mobile);
        $("#consignee_gstin").val(response.Consignee_gstin);
        $("#consignee_email").val(response.Consignee_email);
        $("#consignee_address").val(response.Consignee_address);
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });
  }

  // Event listener for consignee select dropdown change
  $("#consignee_select").on("change", function () {
    var consigneeId = $(this).val();
    if (consigneeId !== "") {
      fetchConsigneeDetails(consigneeId);
    }
  });

  // Fetch consignee names when the page loads
  fetchConsigneeNames();
});

$(document).ready(function () {
  // Function to handle file upload
  $("#attachment").change(function () {
    var fileInput = document.getElementById("attachment");
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;

    // Check if the selected file has an allowed extension
    if (!allowedExtensions.exec(filePath)) {
      alert("Invalid file type. Please select a JPG, JPEG, PNG, or PDF file.");
      fileInput.value = "";
      return false;
    }
  });
});
