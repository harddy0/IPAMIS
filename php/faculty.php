<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - All Faculty</title>
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
                    Manage Users - All Faculty
                </h1>
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="bg-blue-900 text-white py-3 px-6 rounded-t-lg flex justify-center items-center">
                        <h2 class="text-xl font-semibold">All Faculty</h2>
                    </div>
                </div>

                <div class="p-6 bg-blue-100">
                    <div class="relative mb-4 flex items-center">
                        <label for="search" class="block text-gray-700 font-medium mb-2"></label>
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

                    <!-- Table -->
                    <table class="w-full bg-gray-100 border-collapse table-fixed">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="text-left px-4 py-3 border w-1/12">ID Number</th>
                                <th class="text-left px-4 py-3 border w-3/12">Name</th>
                                <th class="text-left px-4 py-3 border w-3/12">Campus</th>
                                <th class="text-left px-4 py-3 border w-2/12">User Type</th>
                                <th class="text-center px-4 py-3 border w-3/12">Action</th>
                            </tr>
                        </thead>
                    </table>

                    <!-- Scrollable Table Body -->
                    <div class="overflow-y-auto max-h-64">
                        <table class="w-full bg-gray-100 border-collapse table-fixed">
                            <tbody>
                                <tr class="hover:bg-blue-50">
                                    <td class="px-4 py-3 border w-1/12">01</td>
                                    <td class="px-4 py-3 border w-3/12">John Arado</td>
                                    <td class="px-4 py-3 border w-3/12">CTU Main</td>
                                    <td class="px-4 py-3 border w-2/12">Faculty</td>
                                    <td class="px-4 py-3 border w-3/12 text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-blue-50">
                                    <td class="px-4 py-3 border w-1/12">02</td>
                                    <td class="px-4 py-3 border w-3/12">Faye Genson</td>
                                    <td class="px-4 py-3 border w-3/12">CTU Main</td>
                                    <td class="px-4 py-3 border w-2/12">Faculty</td>
                                    <td class="px-4 py-3 border w-3/12 text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-blue-50">
                                    <td class="px-4 py-3 border w-1/12">03</td>
                                    <td class="px-4 py-3 border w-3/12">Kingston Canales</td>
                                    <td class="px-4 py-3 border w-3/12">CTU Main</td>
                                    <td class="px-4 py-3 border w-2/12">Faculty</td>
                                    <td class="px-4 py-3 border w-3/12 text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-blue-50">
                                    <td class="px-4 py-3 border w-1/12">04</td>
                                    <td class="px-4 py-3 border w-3/12">Shekinah Juba</td>
                                    <td class="px-4 py-3 border w-3/12">CTU Main</td>
                                    <td class="px-4 py-3 border w-2/12">Faculty</td>
                                    <td class="px-4 py-3 border w-3/12 text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-blue-50">
                                    <td class="px-4 py-3 border w-1/12">05</td>
                                    <td class="px-4 py-3 border w-3/12">Mae Jubaihib</td>
                                    <td class="px-4 py-3 border w-3/12">CTU Main</td>
                                    <td class="px-4 py-3 border w-2/12">Faculty</td>
                                    <td class="px-4 py-3 border w-3/12 text-center">
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