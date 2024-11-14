<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage IP Assets</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/adminMpa.css">
    <link rel="stylesheet" href="../css/adminMipa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body class="overflow-hidden bg-gray-100">

    <div class="fixed top-0 left-0 h-screen w-64">
        <?php include '../includes/dashboard.php'; ?>
    </div>

    <div class="ml-64 flex-grow overflow-y-auto">
        <!-- Header -->
        <?php include '../includes/header.php'; ?>

        <div class="dashboard p-10 flex justify-center items-center min-h-screen">
            <div class="text-center">
                <h2 class="text-3xl font-semibold text-gray-700 mb-10">Manage IP Assets</h2>

                <!-- Navigation Buttons -->
                <div class="space-y-6">
                    <a href="soa.php" class="block bg-gray-200 text-gray-800 font-semibold text-lg py-6 rounded-lg shadow-md hover:bg-gray-300">
                        STATEMENT OF ACCOUNT
                    </a>
                    <a href="or.php" class="block bg-gray-200 text-gray-800 font-semibold text-lg py-6 rounded-lg shadow-md hover:bg-gray-300">
                        OR
                    </a>
                    <a href="formality.php" class="block bg-gray-200 text-gray-800 font-semibold text-lg py-6 rounded-lg shadow-md hover:bg-gray-300">
                        FORMALITY REPORT
                    </a>
                </div>
            </div>
        </div>

        <?php include '../includes/footer.php'; ?>
    </div>
</body>
</html>
