<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin & Staff</title>
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
            <div class="p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">
                    Manage Users - Admin & Staff
                </h1>

                <div class="bg-blue-900 text-white py-3 px-6 rounded-t-lg flex justify-center items-center mb-4">
                    <h2 class="text-xl font-semibold">Admin & Staff</h2>
                </div>

                <div class="p-6 bg-gray-200">
                    <div class="relative mb-4 flex items-center">
                        <input
                            id="search"
                            type="text"
                            placeholder="Search"
                            class="w-full p-3 pl-10 text-black rounded-l-md border border-gray-300 focus:outline-none focus:ring focus:ring-blue-500"
                        />
                        <button class="bg-blue-500 text-white p-3 rounded-r-md hover:bg-blue-700 transition duration-200">
                            Search
                        </button>
                    </div>

                    <table class="w-full bg-gray-100 border-collapse table-fixed">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="px-2 py-3 border w-1/12 text-left">ID</th>
                                <th class="px-4 py-3 border w-2/12 text-left">Name</th>
                                <th class="px-4 py-3 border w-1/12 text-left">User Type</th>
                                <th class="px-4 py-3 border w-2/12 text-left">Campus</th>
                                <th class="px-4 py-3 border w-1.5/12 text-left">Department</th>
                                <th class="px-4 py-3 border w-1.5/12 text-center">Contact#</th>
                                <th class="px-4 py-3 border w-2/12 text-center">Email Address</th>
                                <th class="px-2 py-3 border w-1/12 text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- Scrollable Table Body -->
                    <div class="overflow-y-auto max-h-64">
                        <table class="w-full bg-gray-100 border-collapse table-fixed">
                            <tbody>
                                <tr class="hover:bg-blue-50">
                                    <td class="px-2 py-3 border w-1/12 text-left">01</td>
                                    <td class="px-4 py-3 border w-2/12 text-left">John Arado</td>
                                    <td class="px-4 py-3 border w-1/12 text-left">Admin</td>
                                    <td class="px-4 py-3 border w-2/12 text-left">CTU - Main</td>
                                    <td class="px-4 py-3 border w-1.5/12 text-left">CCICT</td>
                                    <td class="px-4 py-3 border w-1.5/12 text-center">09847362832</td>
                                    <td class="px-4 py-3 border w-2/12 text-center">sample@gmail.com</td>
                                    <td class="px-2 py-3 border w-1/12 text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-2 py-3 border w-1/12 text-left">02</td>
                                    <td class="px-4 py-3 border w-2/12 text-left">Faye Genson</td>
                                    <td class="px-4 py-3 border w-1/12 text-left">Staff</td>
                                    <td class="px-4 py-3 border w-2/12 text-left">CTU - Main</td>
                                    <td class="px-4 py-3 border w-1.5/12 text-left">COT</td>
                                    <td class="px-4 py-3 border w-1.5/12 text-center">09847362832</td>
                                    <td class="px-4 py-3 border w-2/12 text-center">sample@gmail.com</td>
                                    <td class="px-2 py-3 border w-1/12 text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-2 py-3 border w-1/12 text-left">03</td>
                                    <td class="px-4 py-3 border w-2/12 text-left">Kingston Canales</td>
                                    <td class="px-4 py-3 border w-1/12 text-left">Admin</td>
                                    <td class="px-4 py-3 border w-2/12 text-left">CTU - Main</td>
                                    <td class="px-4 py-3 border w-1.5/12 text-left">CME</td>
                                    <td class="px-4 py-3 border w-1.5/12 text-center">09847362832</td>
                                    <td class="px-4 py-3 border w-2/12 text-center">sample@gmail.com</td>
                                    <td class="px-2 py-3 border w-1/12 text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-2 py-3 border w-1/12 text-left">04</td>
                                    <td class="px-4 py-3 border w-2/12 text-left">Shekinah Juba</td>
                                    <td class="px-4 py-3 border w-1/12 text-left">Staff</td>
                                    <td class="px-4 py-3 border w-2/12 text-left">CTU - Main</td>
                                    <td class="px-4 py-3 border w-1.5/12 text-left">CME</td>
                                    <td class="px-4 py-3 border w-1.5/12 text-center">09847362832</td>
                                    <td class="px-4 py-3 border w-2/12 text-center">sample@gmail.com</td>
                                    <td class="px-2 py-3 border w-1/12 text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-2 py-3 border w-1/12 text-left">05</td>
                                    <td class="px-4 py-3 border w-2/12 text-left">Mae Jubahib</td>
                                    <td class="px-4 py-3 border w-1/12 text-left">Admin</td>
                                    <td class="px-4 py-3 border w-2/12 text-left">CTU - Main</td>
                                    <td class="px-4 py-3 border w-1.5/12 text-left">CME</td>
                                    <td class="px-4 py-3 border w-1.5/12 text-center">09847362832</td>
                                    <td class="px-4 py-3 border w-2/12 text-center">sample@gmail.com</td>
                                    <td class="px-2 py-3 border w-1/12 text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php include '../includes/footer.php'; ?>
        </div>
    </div>

</body>
</html>
