<?php
// Include connection and search functions
require_once('include/connection.php');
include('pages/trip_search_functions.php');

// Check if the form data is received via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $partyID = isset($_POST['party_id']) ? $_POST['party_id'] : 'none';
    $fromDate = $_POST['fdate'];
    $toDate = $_POST['tdate'];


    // Fetch search results based on the provided criteria
    if ($partyID != 'none' && !empty($fromDate) && !empty($toDate)) {
        $result = fetchTripsByPartyAndDate($conn, $partyID, $fromDate, $toDate);
    } elseif ($partyID != 'none' && empty($fromDate) && empty($toDate)) {
        $result = fetchTripsByParty($conn, $partyID);
    } elseif ($partyID == 'none' && !empty($fromDate) && !empty($toDate)) {
        $result = fetchTripsByDate($conn, $fromDate, $toDate);
    } else {
       echo "empty";
    }

    // Fetch the trip data and send it back as JSON response
    $tripData = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tripData[] = $row;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($tripData);
    exit;

}
?>
