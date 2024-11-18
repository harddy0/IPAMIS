<?php
// soa_search_download.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';
header('Content-Type: application/json');

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Join statementofaccount with invention_disclosure to fetch details
    $stmt = $conn->prepare("
        SELECT DISTINCT
            s.SOAReference AS reference_code,
            s.InventionDisclosureCode AS invention_code,
            i.employee_name AS inventor,
            s.IPOPHLReceivedDate AS date_added
        FROM
            statementofaccount s
        LEFT JOIN
            invention_disclosure i ON s.InventionDisclosureCode = i.id
        WHERE
            s.SOAReference LIKE CONCAT('%', ?, '%')
    ");
    $stmt->bind_param("s", $query);
    $stmt->execute();
    $result = $stmt->get_result();
    $suggestions = [];

    while ($row = $result->fetch_assoc()) {
        $suggestions[] = [
            'reference_code' => $row['reference_code'],
            'invention_code' => $row['invention_code'],
            'inventor' => $row['inventor'],
            'date_added' => $row['date_added']
        ];
    }

    echo json_encode(['success' => true, 'suggestions' => $suggestions]);
    $stmt->close();
    exit;
}

// Handle download and delete requests as before

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $reference = $_GET['reference'] ?? '';

    if ($action === 'download' && !empty($reference)) {
        $stmt = $conn->prepare("SELECT SOA FROM statementofaccount WHERE SOAReference = ?");
        $stmt->bind_param("s", $reference);
        $stmt->execute();
        $stmt->bind_result($soa);
        if ($stmt->fetch()) {
            header('Content-Type: application/pdf');
            header("Content-Disposition: attachment; filename=\"$reference.pdf\"");
            echo $soa;
        } else {
            echo json_encode(['success' => false, 'message' => 'File not found.']);
        }
        $stmt->close();
        exit;
    }

    if ($action === 'delete' && !empty($reference)) {
        $conn->begin_transaction();
        try {
            $stmt1 = $conn->prepare("UPDATE ipasset SET SOARefCode = NULL WHERE SOARefCode = ?");
            $stmt1->bind_param("s", $reference);
            $stmt1->execute();
            $stmt1->close();

            $stmt2 = $conn->prepare("UPDATE invention_disclosure SET soa_reference_number = NULL WHERE soa_reference_number = ?");
            $stmt2->bind_param("s", $reference);
            $stmt2->execute();
            $stmt2->close();

            $stmt3 = $conn->prepare("DELETE FROM statementofaccount WHERE SOAReference = ?");
            $stmt3->bind_param("s", $reference);
            $stmt3->execute();
            $stmt3->close();

            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'SOA deleted successfully.']);
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => 'Error deleting SOA: ' . $e->getMessage()]);
        }
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
?>