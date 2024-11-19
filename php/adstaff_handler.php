<?php
// adstaff_handler.php

// Start the session
session_start();

// Include the database connection
include '../includes/db_connect.php';

// Determine the action based on the 'action' parameter
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'search') {
    // Handle search operation
    $query = isset($_POST['query']) ? trim($_POST['query']) : '';

    if (empty($query)) {
        // Fetch all users
        $sql = "SELECT UserID, FirstName, MiddleName, LastName, UserType, Campus, Department, EmailAddress 
                FROM `user` 
                ORDER BY UserID ASC";
        $stmt = $conn->prepare($sql);
    } else {
        // Fetch users matching the query
        $sql = "SELECT UserID, FirstName, MiddleName, LastName, UserType, Campus, Department, EmailAddress 
                FROM `user` 
                WHERE CONCAT(FirstName, ' ', IFNULL(MiddleName, ''), ' ', LastName) LIKE ?
                ORDER BY UserID ASC";
        $stmt = $conn->prepare($sql);
        $searchParam = '%' . $query . '%';
        $stmt->bind_param("s", $searchParam);
    }

    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any users are found
        if ($result->num_rows > 0) {
            // Iterate through the users and generate HTML forms
            while ($user = $result->fetch_assoc()) {
                // Construct the full name
                $fullName = htmlspecialchars($user['FirstName'] . ' ' . ($user['MiddleName'] ? $user['MiddleName'] . ' ' : '') . $user['LastName']);

                echo '<form class="grid grid-cols-12 gap-4 items-center p-4 border-b">';
                echo '<input type="text" value="' . htmlspecialchars($user['UserID']) . '" class="col-span-1 px-4 py-2 border rounded-md" readonly />';
                echo '<input type="text" value="' . $fullName . '" class="col-span-2 px-4 py-2 border rounded-md" readonly />';
                echo '<input type="text" value="' . htmlspecialchars($user['UserType']) . '" class="col-span-2 px-4 py-2 border rounded-md" readonly />';
                echo '<input type="text" value="' . htmlspecialchars($user['Campus']) . '" class="col-span-2 px-4 py-2 border rounded-md" readonly />';
                echo '<input type="text" value="' . htmlspecialchars($user['Department']) . '" class="col-span-2 px-4 py-2 border rounded-md" readonly />';
                echo '<input type="text" value="' . htmlspecialchars($user['EmailAddress']) . '" class="col-span-2 px-4 py-2 border rounded-md" readonly />';
                echo '<button type="button" class="col-span-1 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 delete-button" data-userid="' . htmlspecialchars($user['UserID']) . '">Delete</button>';
                echo '</form>';
            }
        } else {
            // If no users found, display a message
            echo '<p class="p-4 text-gray-700">No users found.</p>';
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle SQL preparation errors
        error_log('SQL Prepare Error: ' . $conn->error);
        echo '<p class="p-4 text-red-500">An error occurred while preparing the search.</p>';
    }

} elseif ($action === 'delete') {
    // Handle delete operation

    // Retrieve the UserID from the POST data
    $userID = isset($_POST['UserID']) ? intval($_POST['UserID']) : 0;

    // Validate the UserID
    if ($userID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid User ID.']);
        exit;
    }

    // Optional: Check if the user exists before attempting deletion
    $checkSql = "SELECT * FROM `user` WHERE UserID = ?";
    if ($checkStmt = $conn->prepare($checkSql)) {
        $checkStmt->bind_param("i", $userID);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows === 0) {
            // User does not exist
            echo json_encode(['success' => false, 'message' => 'User not found.']);
            $checkStmt->close();
            exit;
        }

        // Close the check statement
        $checkStmt->close();
    } else {
        // Handle SQL preparation errors
        error_log('SQL Prepare Error: ' . $conn->error);
        echo json_encode(['success' => false, 'message' => 'An error occurred while checking the user.']);
        exit;
    }

    // Prepare the DELETE statement
    $deleteSql = "DELETE FROM `user` WHERE UserID = ?";
    if ($deleteStmt = $conn->prepare($deleteSql)) {
        $deleteStmt->bind_param("i", $userID);
        $deleteSuccess = $deleteStmt->execute();

        if ($deleteSuccess) {
            echo json_encode(['success' => true]);
        } else {
            // Deletion failed
            error_log('Deletion Error: ' . $deleteStmt->error);
            echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
        }

        // Close the delete statement
        $deleteStmt->close();
    } else {
        // Handle SQL preparation errors
        error_log('SQL Prepare Error: ' . $conn->error);
        echo json_encode(['success' => false, 'message' => 'An error occurred while preparing the deletion.']);
    }

} else {
    // If the action is not recognized, return an error
    echo '<p class="p-4 text-red-500">Invalid action.</p>';
}
?>
