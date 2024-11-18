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

        <table class="w-full bg-gray-100 border-collapse">
            <thead class="bg-blue-800 text-white">
                <tr>
                    <th class="text-left px-6 py-3 border">ID Number</th>
                    <th class="text-center px-6 py-3 border">Name</th>
                    <th class="text-left px-6 py-3 border">User Type</th>
                    <th class="text-left px-6 py-3 border">Campus</th>
                    <th class="text-left px-6 py-3 border">Department</th>
                    <th class="text-center px-6 py-3 border">Contact#</th>
                    <th class="text-center px-6 py-3 border">Email Address</th>
                    <th class="text-center px-6 py-3 border">Action</th>
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
            </tbody>
        </table>
    </div>
</div>

             

            <?php include '../includes/footer.php'; ?>
        </div>
    </div>

</body>
</html>
