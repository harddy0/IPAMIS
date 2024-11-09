<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IPAMIS</title>
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body class="bg-cover bg-center h-screen" style="background-image: url('../images/ctu1.png');">
    <div class="login-container flex items-center justify-center h-full">
        <div class="bg-blue-900 bg-opacity-80 p-10 rounded-lg w-full max-h-[90vh] max-w-sm text-white overflow-y-auto">
            <div class="header flex items-center justify-center mb-6 relative">
                <img src="../images/ctulogo.png" alt="Logo 1" class="w-12 h-12 mr-2">
                <h1 class="text-2xl font-bold text-gold mx-2">IPAMIS</h1>
                <img src="../images/pilipinaslogo.png" alt="Logo 2" class="w-14 h-14">
                <span class="border-line absolute left-0"></span>
            </div>
            <?php
            session_start();
            include '../includes/db_connect.php';

            // Initialize error message
            $error_message = "";

            // Check if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = htmlspecialchars(trim($_POST['Email-Address']));
                $password = htmlspecialchars(trim($_POST['password']));

                // Query to check if the email and password match in the database
                $sql = "SELECT * FROM user WHERE EmailAddress = ? AND Password = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $email, $password);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Successful login
                    $user = $result->fetch_assoc();
                    $_SESSION['UserID'] = $user['UserID']; // Store user ID in session
                    $_SESSION['FirstName'] = $user['FirstName'];
                    header("Location: adminMpa.php"); // Redirect to the dashboard or desired page
                    exit();
                } else {
                    // Invalid credentials
                    $error_message = "Invalid email or password.";
                }
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="space-y-4">
                <?php if (!empty($error_message)) : ?>
                    <div class="bg-red-500 p-2 rounded text-center"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <input type="text" name="Email-Address" placeholder="Email Address" required class="w-full px-4 py-2 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-gold">
                <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-gold">
                <div class="flex justify-between items-center text-sm">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="text-gold focus:ring-gold">
                        <span class="ml-2">Remember me</span>
                    </label>
                    <a href="#" class="text-lightblue hover:underline">Forgot Password?</a>
                </div>
                <button type="submit" class="w-full py-2 bg-gold text-blue-900 font-semibold rounded-lg hover:bg-orange-600 focus:outline-none">LOGIN</button>
            </form>
            <p class="mt-4 text-center text-xs">Need assistance? Contact us at <a href="mailto:janeth.ugang@ctu.edu.ph" class="text-lightblue hover:underline">janeth.ugang@ctu.edu.ph</a></p>
        </div>
    </div>
</body>
</html>
