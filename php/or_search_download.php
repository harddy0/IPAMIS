<?php
// or_search_download.php

include '../includes/db_connect.php';
header('Content-Type: application/json');

// Search for OR by Reference Code
if (isset($_GET['referenceCode'])) {
    $referenceCode = trim($_GET['referenceCode']);
    $stmt = $conn->prepare("SELECT eORNumber FROM electronicor WHERE eORNumber LIKE CONCAT('%', ?, '%') LIMIT 5");
    $stmt->bind_param("s", $referenceCode);
    $stmt->execute();
    $result = $stmt->get_result();

    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = [
            'referenceCode' => $row['eORNumber']
        ];
    }
    $stmt->close();

    echo json_encode(['success' => true, 'suggestions' => $suggestions]);
    exit;
}

// Download OR file
if (isset($_GET['download'])) {
    $referenceCode = $_GET['download'];
    $stmt = $conn->prepare("SELECT eOR FROM electronicor WHERE eORNumber = ?");
    $stmt->bind_param("s", $referenceCode);
    $stmt->execute();
    $stmt->bind_result($fileContent);
    $stmt->fetch();
    $stmt->close();

    if ($fileContent) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="OR_' . $referenceCode . '.pdf"');
        echo $fileContent;
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'File not found.']);
        exit;
    }
}

// Delete OR file
if (isset($_GET['delete'])) {
    $referenceCode = $_GET['delete'];

    // Begin transaction
    $conn->begin_transaction();
    try {
        // Nullify OR reference in related tables
        $updateIpAsset = $conn->prepare("UPDATE ipasset SET eORRefCode = NULL WHERE eORRefCode = ?");
        $updateIpAsset->bind_param("s", $referenceCode);
        $updateIpAsset->execute();
        $updateIpAsset->close();

        $updateDisclosure = $conn->prepare("UPDATE invention_disclosure SET eor_number = NULL WHERE eor_number = ?");
        $updateDisclosure->bind_param("s", $referenceCode);
        $updateDisclosure->execute();
        $updateDisclosure->close();

        // Delete from electronicor table
        $deleteOR = $conn->prepare("DELETE FROM electronicor WHERE eORNumber = ?");
        $deleteOR->bind_param("s", $referenceCode);
        $deleteOR->execute();
        $deleteOR->close();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error deleting file.']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
?>
