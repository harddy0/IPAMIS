<?php
// faculty_handler.php

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection
include '../includes/db_connect.php';

// Handle GET requests (Search functionality)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the search query
    $query = isset($_GET['query']) ? $_GET['query'] : '';

    // Prepare the SQL statement
    $sql = "SELECT UserID, FirstName, MiddleName, LastName, Campus, UserType FROM user WHERE Status = 'Active' AND UserType = 'Faculty'";

    if (!empty($query)) {
        $sql .= " AND (FirstName LIKE ? OR MiddleName LIKE ? OR LastName LIKE ?)";
    }

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        if (!empty($query)) {
            $likeQuery = '%' . $query . '%';
            $stmt->bind_param('sss', $likeQuery, $likeQuery, $likeQuery);
        }

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch data
        $facultyData = [];
        while ($row = $result->fetch_assoc()) {
            $facultyData[] = [
                'UserID' => $row['UserID'],
                'Name' => $row['FirstName'] . ' ' . $row['MiddleName'] . ' ' . $row['LastName'],
                'Campus' => $row['Campus'],
                'UserType' => $row['UserType']
            ];
        }

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($facultyData);

        // Close the statement
        $stmt->close();
    } else {
        // Handle SQL preparation error
        http_response_code(500);
        echo json_encode(['error' => 'Failed to prepare statement.']);
    }
}

// Handle POST requests (Delete functionality)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID
    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';

    if (!empty($userId)) {
        // Prepare the SQL statement to update the Status
        $sql = "UPDATE user SET Status = 'Inactive' WHERE UserID = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('i', $userId);

            if ($stmt->execute()) {
                //echo "Faculty member deleted successfully.";
            } else {
                //echo "Error deleting faculty member.";
            }

            // Close the statement
            $stmt->close();
        } else {
            //echo "Failed to prepare statement.";
        }
    } else {
        //echo "Invalid user ID.";
    }
}

// Close the database connection
$conn->close();
?>
