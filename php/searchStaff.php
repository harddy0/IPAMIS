<?php
include '../includes/db_connect.php';

$query = isset($_GET['query']) ? trim($_GET['query']) : '';

if ($query !== '') {
    $stmt = $conn->prepare("SELECT UserID, CONCAT(FirstName, ' ', LastName) AS FullName FROM user WHERE UserType = 'Staff' AND Status = 'Active' AND (FirstName LIKE ? OR LastName LIKE ?)");
    $likeQuery = "%" . $query . "%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($user = $result->fetch_assoc()) {
            echo "<li class='px-4 py-2 border-b'>
                    <a href='adminEditStaff.php?user_id={$user['UserID']}' class='text-blue-600 hover:underline'>
                        " . htmlspecialchars($user['UserID'] . " - " . $user['FullName']) . "
                    </a>
                  </li>";
        }
    } else {
        echo "<li class='px-4 py-2 text-gray-500'>No matching staff found.</li>";
    }

    $stmt->close();
}
?>