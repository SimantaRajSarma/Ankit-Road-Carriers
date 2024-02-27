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
