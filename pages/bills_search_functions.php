<?php

// Function to fetch bills by party ID and bill date
function fetchBillsByPartyAndDate($conn, $partyID, $bill_date) {
    $query = "SELECT party_bill.*, party.party_name FROM party_bill INNER JOIN party ON party_bill.party_id = party.party_id WHERE party_bill.party_id = ? AND bill_date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $partyID, $bill_date);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Function to fetch bills by party ID
function fetchBillsByParty($conn, $partyID) {
    $query = "SELECT party_bill.*, party.party_name FROM party_bill INNER JOIN party ON party_bill.party_id = party.party_id WHERE party_bill.party_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $partyID);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Function to fetch bills by bill date
function fetchBillsByDate($conn, $bill_date) {
    $query = "SELECT party_bill.*, party.party_name FROM party_bill INNER JOIN party ON party_bill.party_id = party.party_id WHERE bill_date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $bill_date);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Fetch Parties with IDs
function fetchParty($conn) {
    $party_data = [];
    $sql = "SELECT party_id, party_name FROM party";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $party_data[] = array(
                'id' => $row["party_id"], 
                'name' => $row["party_name"]
            );
        }
    } else {
        $party_data[] = array(
            'id' => null, 
            'name' => "No parties found"
        );
    }
    return $party_data;
  }
?>