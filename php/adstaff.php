<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body class="overflow-hidden">

    <div class="main-wrapper">
        <!-- Sidebar -->
        <div class="fixed top-0 left-0 h-screen w-64">
            <?php include '../includes/dashboard.php'; ?>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper ml-64 flex-grow overflow-y-auto">
            <!-- Header -->
            <?php include '../includes/header.php'; ?>

             <!-- Main Content -->
             <div class="main-content p-6">
                <div class="container mx-auto">
                    <!-- Manage Users Header with Back Button -->
                    <h1 class="text-2xl font-bold mb-4 flex items-center space-x-4">
                        <!-- Back Button -->
                        <button onclick="history.back()" class="text-gray-800 font-semibold px-3 py-1 rounded-lg hover:bg-gray-400 flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i> ←
                        </button>
                        <!-- Title -->
                        <span class="flex items-center">
                            <i class="fas fa-users-cog mr-1"></i> Admin & Staff
                    </h1>

                    <!-- User Table Container -->
                    <div class="bg-gray-100 rounded-lg shadow-lg p-6">
                        <!-- Admin & Staff Header -->
                        <div class="bg-blue-900 text-white text-center py-2 font-semibold rounded-t-lg">
                            Admin & Staff
                        </div>
                        
                        <!-- Search and Add Section -->
                        <div class="flex justify-between items-center bg-gray-200 p-4 rounded-b-lg">
                            <!-- Search Bar -->
                            <div class="flex items-center space-x-2 w-full">
                                <label class="text-gray-600">Search</label>
                                <input type="text" placeholder="" class="w-full px-4 py-2 rounded-lg bg-gray-100 text-gray-900">
                                <button class="text-gray-600"><i class="fas fa-times"></i></button>
                            </div>
                            <!-- Add Button -->
                            <button onclick="window.location.href='addUser.php'" class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-yellow-600 ml-2">
                                ADD USER
                            </button>
                        </div>

                        <!-- User Data Table -->
                        <div class="overflow-x-auto mt-4">
                            <table class="w-full text-left">
                                <thead class="bg-blue-700 text-white">
                                    <tr>
                                        <th class="py-2 px-4">ID Number</th>
                                        <th class="py-2 px-4">Name</th>
                                        <th class="py-2 px-4">User Type</th>
                                        <th class="py-2 px-4">Campus</th>
                                        <th class="py-2 px-4">Department</th>
                                        <th class="py-2 px-4">Contact#</th>
                                        <th class="py-2 px-4">Email Address</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <tr class="border-b">
                                        <td class="py-3 px-4">01</td>
                                        <td class="py-3 px-4">John Arado</td>
                                        <td class="py-3 px-4">Admin</td>
                                        <td class="py-3 px-4">CTU - Main</td>
                                        <td class="py-3 px-4">CCICT</td>
                                        <td class="py-3 px-4">09847302832</td>
                                        <td class="py-3 px-4">sample@gmail.com <i class="fas fa-copy ml-2"></i></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 px-4">02</td>
                                        <td class="py-3 px-4">Faye Genson</td>
                                        <td class="py-3 px-4">Staff</td>
                                        <td class="py-3 px-4">CTU - Main</td>
                                        <td class="py-3 px-4">COT</td>
                                        <td class="py-3 px-4">09847302832</td>
                                        <td class="py-3 px-4">sample@gmail.com <i class="fas fa-copy ml-2"></i></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 px-4">03</td>
                                        <td class="py-3 px-4">Kingston Canales</td>
                                        <td class="py-3 px-4">Admin</td>
                                        <td class="py-3 px-4">CTU - Main</td>
                                        <td class="py-3 px-4">CME</td>
                                        <td class="py-3 px-4">09847302832</td>
                                        <td class="py-3 px-4">sample@gmail.com <i class="fas fa-copy ml-2"></i></td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4">04</td>
                                        <td class="py-3 px-4">Mae Jubahib</td>
                                        <td class="py-3 px-4">Staff</td>
                                        <td class="py-3 px-4">CTU - Main</td>
                                        <td class="py-3 px-4">CCICT</td>
                                        <td class="py-3 px-4">09847302832</td>
                                        <td class="py-3 px-4">sample@gmail.com <i class="fas fa-copy ml-2"></i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php include '../includes/footer.php'; ?>
            
        </div>
    </div>

</body>
</html>
