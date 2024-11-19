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

                    <!-- Header -->
                    <div class="grid grid-cols-12 gap-4 items-center bg-blue-800 text-white px-4 py-2 rounded-t-lg">
                        <div class="col-span-1">ID Number</div>
                        <div class="col-span-3">Name</div>
                        <div class="col-span-3">Campus</div>
                        <div class="col-span-2">User Type</div>
                    </div>

                    <!-- Scrollable Form Container -->
                    <div class="overflow-y-auto max-h-64 space-y-4 bg-white rounded-b-lg">
                        <!-- Record 1 -->
                        <form class="grid grid-cols-12 gap-4 items-center p-4 border-b">
                            <input type="text" value="01" class="col-span-1 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="John Arado" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="CTU Main" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="Faculty" class="col-span-2 px-4 py-2 border rounded-md" readonly />
                            <button type="button" class="col-span-3 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                Delete
                            </button>
                        </form>

                        <!-- Record 2 -->
                        <form class="grid grid-cols-12 gap-4 items-center p-4 border-b">
                            <input type="text" value="02" class="col-span-1 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="Faye Genson" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="CTU Main" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="Faculty" class="col-span-2 px-4 py-2 border rounded-md" readonly />
                            <button type="button" class="col-span-3 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                Delete
                            </button>
                        </form>

                        <!-- Record 3 -->
                        <form class="grid grid-cols-12 gap-4 items-center p-4 border-b">
                            <input type="text" value="03" class="col-span-1 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="Mae Jubahib" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="CTU Main" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="Faculty" class="col-span-2 px-4 py-2 border rounded-md" readonly />
                            <button type="button" class="col-span-3 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                Delete
                            </button>
                        </form>

                        <!-- Record 4 -->
                        <form class="grid grid-cols-12 gap-4 items-center p-4 border-b">
                            <input type="text" value="04" class="col-span-1 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="Sheki Nah" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="CTU Main" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="Faculty" class="col-span-2 px-4 py-2 border rounded-md" readonly />
                            <button type="button" class="col-span-3 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                Delete
                            </button>
                        </form>

                        <!-- Record 5 -->
                        <form class="grid grid-cols-12 gap-4 items-center p-4">
                            <input type="text" value="05" class="col-span-1 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="Kingston Canales" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="CTU Main" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                            <input type="text" value="Faculty" class="col-span-2 px-4 py-2 border rounded-md" readonly />
                            <button type="button" class="col-span-3 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <?php include '../includes/footer.php'; ?>
        </div>
    </div>

</body>
</html>
