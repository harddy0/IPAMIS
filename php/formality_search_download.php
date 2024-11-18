<?php
// formality_search_download.php
include '../includes/db_connect.php';
header('Content-Type: application/json');

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $stmt = $conn->prepare("
        SELECT DISTINCT 
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
        LIMIT 5
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

if (isset($_GET['download'])) {
    $referenceCode = $_GET['download'];

    $stmt = $conn->prepare("SELECT Document FROM formalityreport WHERE DocumentNumber = ?");
    $stmt->bind_param("s", $referenceCode);
    $stmt->execute();
    $stmt->bind_result($fileContent);
    if ($stmt->fetch()) {
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename=\"$referenceCode.pdf\"");
        echo $fileContent;
    } else {
        echo json_encode(['success' => false, 'message' => 'File not found.']);
    }
    $stmt->close();
    exit;
}

if (isset($_GET['delete'])) {
    $referenceCode = $_GET['delete'];

    $conn->begin_transaction();
    try {
        // Remove reference from ipasset table
        $stmt = $conn->prepare("UPDATE ipasset SET FormalityRefCode = NULL WHERE FormalityRefCode = ?");
        $stmt->bind_param("s", $referenceCode);
        $stmt->execute();
        $stmt->close();

        // Remove reference from invention_disclosure table
        $stmt = $conn->prepare("UPDATE invention_disclosure SET document_number = NULL WHERE document_number = ?");
        $stmt->bind_param("s", $referenceCode);
        $stmt->execute();
        $stmt->close();

        // Delete from formalityreport table
        $stmt = $conn->prepare("DELETE FROM formalityreport WHERE DocumentNumber = ?");
        $stmt->bind_param("s", $referenceCode);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error deleting the Formality Report.']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
?>