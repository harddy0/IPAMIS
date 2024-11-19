<?php
// formality_search_download.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';

// Handle 'download' and 'delete' actions first
if (isset($_GET['action']) && isset($_GET['reference'])) {
    $action = $_GET['action'];
    $reference = $_GET['reference'];

    if ($action === 'download') {
        // Fetch the Formality Report file from the database
        $stmt = $conn->prepare("SELECT Document FROM formalityreport WHERE DocumentNumber = ?");
        $stmt->bind_param("s", $reference);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($document);
            $stmt->fetch();
            if (!empty($document)) {
                header('Content-Type: application/pdf');
                header("Content-Disposition: attachment; filename=\"{$reference}.pdf\"");
                header('Content-Length: ' . strlen($document));
                echo $document;
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
            $stmt1 = $conn->prepare("UPDATE ipasset SET FormalityRefCode = NULL WHERE FormalityRefCode = ?");
            $stmt1->bind_param("s", $reference);
            $stmt1->execute();
            $stmt1->close();

            $stmt2 = $conn->prepare("UPDATE invention_disclosure SET document_number = NULL WHERE document_number = ?");
            $stmt2->bind_param("s", $reference);
            $stmt2->execute();
            $stmt2->close();

            // Delete the Formality Report record
            $stmt3 = $conn->prepare("DELETE FROM formalityreport WHERE DocumentNumber = ?");
            $stmt3->bind_param("s", $reference);
            $stmt3->execute();
            $stmt3->close();

            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Formality Report deleted successfully and related tables updated.']);
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => 'Error deleting Formality Report: ' . $e->getMessage()]);
        }
        exit;
    }
}

// For other requests, set Content-Type to application/json
header('Content-Type: application/json');

// Handle search query
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Fetch Formality Report records based on search query
    $stmt = $conn->prepare("
        SELECT
            f.DocumentNumber AS reference_code,
            f.InventionDisclosureCode AS invention_code,
            i.employee_name AS inventor,
            f.ReceivedDate AS date_added
        FROM
            formalityreport f
        LEFT JOIN
            invention_disclosure i ON f.InventionDisclosureCode = i.id
        WHERE
            f.DocumentNumber LIKE CONCAT('%', ?, '%')
            OR i.employee_name LIKE CONCAT('%', ?, '%')
    ");
    $stmt->bind_param("ss", $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();

    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = [
            'reference_code' => $row['reference_code'],
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