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
    <style>
        table {
            table-layout: fixed; /* Ensures consistent column widths */
            width: 100%; /* Make the table span full width */
            border-collapse: collapse; /* Ensure borders collapse properly */
        }

        thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #2a4365; /* Matches the blue header color */
            text-align: left;
            padding: 8px;
        }

        tbody td {
            padding: 8px;
        }

        th, td {
            border: 1px solid #ccc; /* Optional: Better visual separation */
        }
    </style>
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
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="bg-blue-900 text-white py-3 px-6 rounded-t-lg flex justify-center items-center">
                        <h2 class="text-xl font-semibold">Admin & Staff</h2>
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

                    <!-- Wrapper for the table to add scroll functionality -->
                    <div class="overflow-y-auto max-h-64">
                        <table>
                            <thead class="bg-blue-800 text-white">
                                <tr>
                                    <th class="text-left px-6 py-3">ID Number</th>
                                    <th class="text-center px-6 py-3">Name</th>
                                    <th class="text-left px-6 py-3">User Type</th>
                                    <th class="text-left px-6 py-3">Campus</th>
                                    <th class="text-left px-6 py-3">Department</th>
                                    <th class="text-center px-6 py-3">Contact#</th>
                                    <th class="text-center px-6 py-3">Email Address</th>
                                    <th class="text-center px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-3 border">01</td>
                                    <td class="px-6 py-3 border text-center">John Arado</td>
                                    <td class="px-6 py-3 border">Admin</td>
                                    <td class="px-6 py-3 border">CTU - Main</td>
                                    <td class="px-6 py-3 border">CCICT</td>
                                    <td class="px-6 py-3 border text-center">09847362832</td>
                                    <td class="px-6 py-3 border text-center">sample@gmail.com</td>
                                    <td class="px-6 py-3 border text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-3 border">02</td>
                                    <td class="px-6 py-3 border text-center">Faye Genson</td>
                                    <td class="px-6 py-3 border">Staff</td>
                                    <td class="px-6 py-3 border">CTU - Main</td>
                                    <td class="px-6 py-3 border">COT</td>
                                    <td class="px-6 py-3 border text-center">09847362832</td>
                                    <td class="px-6 py-3 border text-center">sample@gmail.com</td>
                                    <td class="px-6 py-3 border text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-3 border">03</td>
                                    <td class="px-6 py-3 border text-center">Kingston Canales</td>
                                    <td class="px-6 py-3 border">Admin</td>
                                    <td class="px-6 py-3 border">CTU - Main</td>
                                    <td class="px-6 py-3 border">CME</td>
                                    <td class="px-6 py-3 border text-center">09847362832</td>
                                    <td class="px-6 py-3 border text-center">sample@gmail.com</td>
                                    <td class="px-6 py-3 border text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-3 border">04</td>
                                    <td class="px-6 py-3 border text-center">Mae Jubaihib</td>
                                    <td class="px-6 py-3 border">Staff</td>
                                    <td class="px-6 py-3 border">CTU - Main</td>
                                    <td class="px-6 py-3 border">CCICT</td>
                                    <td class="px-6 py-3 border text-center">09847362832</td>
                                    <td class="px-6 py-3 border text-center">sample@gmail.com</td>
                                    <td class="px-6 py-3 border text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-3 border">05</td>
                                    <td class="px-6 py-3 border text-center">Ana Cruz</td>
                                    <td class="px-6 py-3 border">Staff</td>
                                    <td class="px-6 py-3 border">CTU - Danao</td>
                                    <td class="px-6 py-3 border">CCICT</td>
                                    <td class="px-6 py-3 border text-center">09785362832</td>
                                    <td class="px-6 py-3 border text-center">ana.cruz@gmail.com</td>
                                    <td class="px-6 py-3 border text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-3 border">06</td>
                                    <td class="px-6 py-3 border text-center">Liam Santos</td>
                                    <td class="px-6 py-3 border">Admin</td>
                                    <td class="px-6 py-3 border">CTU - Argao</td>
                                    <td class="px-6 py-3 border">COT</td>
                                    <td class="px-6 py-3 border text-center">09123456789</td>
                                    <td class="px-6 py-3 border text-center">liam.santos@gmail.com</td>
                                    <td class="px-6 py-3 border text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-3 border">07</td>
                                    <td class="px-6 py-3 border text-center">Sophia Gomez</td>
                                    <td class="px-6 py-3 border">Staff</td>
                                    <td class="px-6 py-3 border">CTU - Naga</td>
                                    <td class="px-6 py-3 border">CCICT</td>
                                    <td class="px-6 py-3 border text-center">09384726381</td>
                                    <td class="px-6 py-3 border text-center">sophia.gomez@gmail.com</td>
                                    <td class="px-6 py-3 border text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-3 border">08</td>
                                    <td class="px-6 py-3 border text-center">Miguel Ramos</td>
                                    <td class="px-6 py-3 border">Admin</td>
                                    <td class="px-6 py-3 border">CTU - Moalboal</td>
                                    <td class="px-6 py-3 border">CME</td>
                                    <td class="px-6 py-3 border text-center">09483736271</td>
                                    <td class="px-6 py-3 border text-center">miguel.ramos@gmail.com</td>
                                    <td class="px-6 py-3 border text-center">
                                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                                            🗑
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-3 border">09</td>
                                    <td class="px-6 py-3 border text-center">Ella Cruz</td>
                                    <td class="px-6 py-3 border">Staff</td>
                                    <td class="px-6 py-3 border">CTU - Barili</td>
                                    <td class="px-6 py-3 border">COT</td>
                                    <td class="px-6 py-3 border text-center">09284373628</td>
                                    <td class="px-6 py-3 border text-center">ella.cruz@gmail.com</td>
                                    <td class="px-6 py-3 border text-center">
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
