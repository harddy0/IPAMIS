<?php
// soa_search_download.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';

// Handle 'download' and 'delete' actions first
if (isset($_GET['action']) && isset($_GET['reference'])) {
    $action = $_GET['action'];
    $reference = $_GET['reference'];

    if ($action === 'download') {
        // Fetch the SOA file from the database
        $stmt = $conn->prepare("SELECT SOA FROM statementofaccount WHERE SOAReference = ?");
        $stmt->bind_param("s", $reference);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($soa);
            $stmt->fetch();
            if (!empty($soa)) {
                header('Content-Type: application/pdf');
                header("Content-Disposition: attachment; filename=\"{$reference}.pdf\"");
                header('Content-Length: ' . strlen($soa));
                echo $soa;
            } else {
                header('Content-Type: text/plain');
                echo "File is empty.";
            }
        } else {
            header('Content-Type: text/plain');
            echo "File not found.";
        }
        $stmt->close();
        exit;
    }

    if ($action === 'delete') {
        header('Content-Type: application/json');
        $conn->begin_transaction();
        try {
            // Update related tables
            $stmt1 = $conn->prepare("UPDATE ipasset SET SOARefCode = NULL WHERE SOARefCode = ?");
            $stmt1->bind_param("s", $reference);
            $stmt1->execute();
            $stmt1->close();

            $stmt2 = $conn->prepare("UPDATE invention_disclosure SET soa_reference_number = NULL WHERE soa_reference_number = ?");
            $stmt2->bind_param("s", $reference);
            $stmt2->execute();
            $stmt2->close();

            // Delete the SOA record
            $stmt3 = $conn->prepare("DELETE FROM statementofaccount WHERE SOAReference = ?");
            $stmt3->bind_param("s", $reference);
            $stmt3->execute();
            $stmt3->close();

            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'SOA deleted successfully and related tables updated.']);
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => 'Error deleting SOA: ' . $e->getMessage()]);
        }
        exit;
    }
}

// For other requests, set Content-Type to application/json
header('Content-Type: application/json');

// Handle search query
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Fetch SOA records based on search query
    $stmt = $conn->prepare("
        SELECT
            s.SOAReference AS soa_code,
            s.InventionDisclosureCode AS invention_code,
            i.employee_name AS inventor,
            s.IPOPHLReceivedDate AS date_added
        FROM
            statementofaccount s
        LEFT JOIN
            invention_disclosure i ON s.InventionDisclosureCode = i.id
        WHERE
            s.SOAReference LIKE CONCAT('%', ?, '%')
            OR i.employee_name LIKE CONCAT('%', ?, '%')
    ");
    $stmt->bind_param("ss", $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();

    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = [
            'soa_code' => $row['soa_code'],
            'invention_code' => $row['invention_code'],
            'inventor' => $row['inventor'],
            'date_added' => $row['date_added']
        ];
    }

    echo json_encode(['success' => true, 'records' => $records]);
    $stmt->close();
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
?>
