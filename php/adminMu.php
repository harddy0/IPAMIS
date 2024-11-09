<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Admin Manage IP Assets</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adminMu.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
=======
    <title>Admin Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adminMu.css">
>>>>>>> 490b04d03e0c46edcc9ffbb17ad00cf202c76edd
</head>
<body>
   
    <?php include '../includes/dashboard.php'; ?>
    <?php include '../includes/header.php'; ?>

<<<<<<< HEAD
    <div class="container p-4 mt-10 pb-10 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Manage Users</h1>
            <button class="bg-yellow-500 text-white font-semibold py-1 px-4 rounded flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                ADD
            </button>
            <div class="relative">
                <input type="text" class="bg-gray-300 rounded-full py-2 px-4 text-gray-700" placeholder="Search">
                <button class="absolute right-2 top-2 text-gray-500 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-3.5 3.5m0 0L8 20m7-8.5A6.5 6.5 0 1114 7a6.5 6.5 0 011 7.5z"></path></svg>
=======
            <div class="logout">
                <span class="icon">🚪</span> Log out
            </div>
        </div>
    </div>
    
    <div class="dashboard">
        <div class="header">
            <h2>IP Asset Management and Information System</h2>
            <img src="../images/pilipinaslogo.png" alt="Logo" class="header-logo">
        </div>
        
        <hr class="custom-line">
        
        <!-- Main container for Manage Users content -->
        <div class="container p-10 m-6 mt-10 pb-16 shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Manage Users</h3>
                <button class="bg-yellow-500 text-white font-semibold py-1 px-4 rounded flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    ADD
>>>>>>> 490b04d03e0c46edcc9ffbb17ad00cf202c76edd
                </button>
                <div class="relative">
                    <input type="text" class="bg-gray-300 rounded-full py-2 px-4 text-gray-700" placeholder="Search">
                    <button class="absolute right-2 top-2 text-gray-500 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-3.5 3.5m0 0L8 20m7-8.5A6.5 6.5 0 1114 7a6.5 6.5 0 011 7.5z"></path></svg>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <!-- Left Column: User List -->
                <div>
                    <div class="bg-gray-700 text-white font-semibold rounded-t px-4 py-2">ID Number</div>
                    <ul class="bg-gray-300 text-gray-800 rounded-b">
                        <?php 
                        $users = [
                            ['id' => '01', 'name' => 'John Arado'],
                            ['id' => '02', 'name' => 'Faye Genson'],
                            ['id' => '03', 'name' => 'Kingston Canales'],
                            ['id' => '04', 'name' => 'Mae Jubahib'],
                            ['id' => '05', 'name' => 'Janneth Ugang']
                        ];
                        foreach ($users as $user) {
                            echo "<li class='px-4 py-2 border-b'>{$user['id']} - {$user['name']}</li>";
                        }
                        ?>
                    </ul>
                </div>

                <!-- Middle Column: Faculty Requests -->
                <div>
                    <div class="bg-blue-700 text-white font-semibold rounded-t px-4 py-2 flex items-center justify-between">
                        Faculty Request
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-4h2v2H9v-2zm0-8h2v6H9V6z"></path></svg>
                    </div>
                    <div class="bg-gray-300 rounded-b">
                        <?php 
                        $requests = [
                            'Shekinah Olarte',
                            'Dahlia Genson'
                        ];
                        foreach ($requests as $request) {
                            echo "<div class='px-4 py-2 flex items-center justify-between'>
                                    <span>$request</span>
                                    <div>
                                        <button class='bg-yellow-500 text-white px-2 py-1 rounded mr-2'>Accept</button>
                                        <button class='bg-gray-500 text-white px-2 py-1 rounded'>Decline</button>
                                    </div>
                                  </div>";
                        }
                        ?>
                    </div>
                </div>

                <!-- Right Column: User Actions -->
                <div>
                    <div class="bg-gray-700 text-white font-semibold rounded-t px-4 py-2">Name</div>
                    <ul class="bg-gray-300 text-gray-800 rounded-b">
                        <?php 
                        foreach ($users as $user) {
                            echo "<li class='px-4 py-2 border-b flex items-center justify-between'>
                                    <span>{$user['name']}</span>
                                    <button class='text-gray-500 hover:text-red-500'>
                                        <svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'></path></svg>
                                    </button>
                                  </li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
<<<<<<< HEAD
    </div>
    <?php include '../includes/footer.php'; ?>
    </div>
=======

        <div class="footer flex items-center justify-center">
                <p class="text-gray-500 text-sm">Developed By: IPAMIS DevTeam | 2024 © IPAMIS</p>
        </div>

   </div>
>>>>>>> 490b04d03e0c46edcc9ffbb17ad00cf202c76edd


</body>
</html>
