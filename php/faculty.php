<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/adminVa.css">
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
                    <!-- Manage Users Header -->
                    <h1 class="text-2xl font-bold mb-4 flex items-center">
                        <span class="mr-1"><i class="fas fa-users-cog"></i></span> Manage Users
                    </h1>

                    <!-- User Table -->
                    <div class="bg-gray-200 p-6 rounded-lg shadow-md">
                        <!-- Faculty Header -->
                        <div class="bg-blue-900 text-white text-center py-2 font-semibold rounded-t-lg">
                            All Faculty
                        </div>
                        
                        <!-- Search Bar -->
                        <div class="bg-white p-4 flex items-center space-x-2">
                            <input type="text" placeholder="Search" class="w-full px-4 py-2 rounded-lg bg-gray-100 text-gray-900">
                            <button class="text-gray-600"><i class="fas fa-times"></i></button>
                        </div>

                        <!-- User Data Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left mt-4">
                                <thead class="bg-blue-700 text-white">
                                    <tr>
                                        <th class="py-2 px-4">ID Number</th>
                                        <th class="py-2 px-4">Name</th>
                                        <th class="py-2 px-4">Campus</th>
                                        <th class="py-2 px-4">User Type</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-50">
                                    <tr class="border-b">
                                        <td class="py-3 px-4">01</td>
                                        <td class="py-3 px-4">John Arado</td>
                                        <td class="py-3 px-4">CTU Main</td>
                                        <td class="py-3 px-4">Admin <i class="fas fa-cog"></i></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 px-4">02</td>
                                        <td class="py-3 px-4">Faye Genson</td>
                                        <td class="py-3 px-4">CTU Main</td>
                                        <td class="py-3 px-4">Staff <i class="fas fa-cog"></i></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 px-4">03</td>
                                        <td class="py-3 px-4">Kingston Canales</td>
                                        <td class="py-3 px-4">CTU Main</td>
                                        <td class="py-3 px-4">Admin <i class="fas fa-cog"></i></td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4">04</td>
                                        <td class="py-3 px-4">Mae Jubahib</td>
                                        <td class="py-3 px-4">CTU Main</td>
                                        <td class="py-3 px-4">Staff <i class="fas fa-cog"></i></td>
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
