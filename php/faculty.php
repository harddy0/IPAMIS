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
            <div class="relative mb-4">
                <label for="search" class="block text-gray-700 font-medium mb-2">Search</label>
                <div class="relative">
                    <input
                        id="search"
                        type="text"
                        placeholder="Search"
                        class="w-full p-3 pl-10 text-black rounded-md border border-gray-300 focus:outline-none focus:ring focus:ring-blue-500"
                    />
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 absolute top-1/2 transform -translate-y-1/2 left-3 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m4-6a6 6 0 11-4.293 10.293L5 20l1.707-1.707A6 6 0 0110 4z" />
                    </svg>
                </div>
            </div>
            <table class="w-full bg-gray-100 border-collapse">
                <thead class="bg-blue-800 text-white">
                    <tr>
                        <th class="text-left px-6 py-3 border">ID Number</th>
                        <th class="text-center px-6 py-3 border">Name</th>
                        <th class="text-left px-6 py-3 border">Campus</th>
                        <th class="text-left px-6 py-3 border">User Type</th>
                        <th class="text-center px-6 py-3 border">Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-blue-50">
                        <td class="px-6 py-3 border">01</td>
                        <td class="px-6 py-3 border text-center">John Arado</td>
                        <td class="px-6 py-3 border">CTU Main</td>
                        <td class="px-6 py-3 border">Faculty</td>
                        <td class="px-6 py-3 border text-center">
                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                            🗑
                        </button>

                        </td>
                    </tr>

                    <tr class="hover:bg-blue-50">
                        <td class="px-6 py-3 border">02</td>
                        <td class="px-6 py-3 border text-center">Faye Genson</td>
                        <td class="px-6 py-3 border">CTU Main</td>
                        <td class="px-6 py-3 border">Faculty</td>
                        <td class="px-6 py-3 border text-center">
                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                            🗑
                        </button>

                        </td>
                    </tr>

                    <tr class="hover:bg-blue-50">
                        <td class="px-6 py-3 border">03</td>
                        <td class="px-6 py-3 border text-center">Kingston Canales</td>
                        <td class="px-6 py-3 border">CTU Main</td>
                        <td class="px-6 py-3 border">Faculty</td>
                        <td class="px-6 py-3 border text-center">
                        <button class="text-red-500 hover:text-red-700 text-3xl hover:text-xl transition-all duration-200">
                             🗑
                        </button>

                        </td>
                    </tr>

                    <tr class="hover:bg-blue-50">
                        <td class="px-6 py-3 border">04</td>
                        <td class="px-6 py-3 border text-center">Mae Jubaihib</td>
                        <td class="px-6 py-3 border">CTU Main</td>
                        <td class="px-6 py-3 border">Faculty</td>
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
