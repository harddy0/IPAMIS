<?php
session_start();

include '../includes/db_connect.php';

// Optional: Implement authentication checks here
// ...

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'search') {
        // Handle search action
        $query = isset($_POST['query']) ? $_POST['query'] : '';

        // Prepare the SQL statement to prevent SQL injection
        $sql = "SELECT * FROM user WHERE Status = 'Active' AND UserType IN ('Admin', 'Staff')";

        if (!empty($query)) {
            // If there's a search query, add a WHERE clause
            $sql .= " AND (FirstName LIKE ? OR MiddleName LIKE ? OR LastName LIKE ?)";
            $stmt = $conn->prepare($sql);
            $likeQuery = '%' . $query . '%';
            $stmt->bind_param('sss', $likeQuery, $likeQuery, $likeQuery);
        } else {
            $stmt = $conn->prepare($sql);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any users found
        if ($result->num_rows > 0) {
            // Start building the output HTML
            $output = '';

            while ($row = $result->fetch_assoc()) {
                // Build HTML for each user
                $output .= '<div class="grid grid-cols-12 gap-4 items-center px-4 py-2 border-b">';
                $output .= '<div class="col-span-1">' . htmlspecialchars($row['UserID']) . '</div>';
                $output .= '<div class="col-span-2">' . htmlspecialchars($row['FirstName'] . ' ' . $row['MiddleName'] . ' ' . $row['LastName']) . '</div>';
                $output .= '<div class="col-span-2">' . htmlspecialchars($row['UserType']) . '</div>';
                $output .= '<div class="col-span-2">' . htmlspecialchars($row['Campus']) . '</div>';
                $output .= '<div class="col-span-2">' . htmlspecialchars($row['Department']) . '</div>';
                $output .= '<div class="col-span-2">' . htmlspecialchars($row['EmailAddress']) . '</div>';
                $output .= '<div class="col-span-1 text-center">';
                $output .= '<button class="delete-button bg-red-500 text-white px-2 py-1 rounded" data-userid="' . htmlspecialchars($row['UserID']) . '">Delete</button>';
                $output .= '</div>';
                $output .= '</div>';
            }
        } else {
            $output = '<p class="p-4 text-gray-700">No users found.</p>';
        }

        echo $output;

        $stmt->close();

    } elseif ($action === 'delete') {
        // Handle delete action (set status to 'Inactive')
        $userId = isset($_POST['UserID']) ? $_POST['UserID'] : '';

        if (!empty($userId)) {
            // Update user's Status to 'Inactive'
            $sql = "UPDATE user SET Status = 'Inactive' WHERE UserID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $userId);

            if ($stmt->execute()) {
                // Return success response
                echo json_encode(['success' => true]);
            } else {
                // Return error response
                echo json_encode(['success' => false, 'message' => 'Failed to update user status.']);
            }

            $stmt->close();

        } else {
            // Return error response
            echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
        }
    }

    $conn->close();
}
?>
