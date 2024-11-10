<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adminMu.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>
   
    <?php include '../includes/dashboard.php'; ?>
    <?php include '../includes/header.php'; ?>

    <div class="container p-4 mt-10 pb-10 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Manage Users</h1>
                <button class="custom-add-button">
                <svg class="add-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                 ADD
                </button>
            <div class="relative">
                <input type="text" class="bg-gray-300 rounded-full py-2 px-4 text-gray-700" placeholder="Search">
                <button class="absolute right-2 top-2 text-gray-500 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                        <line x1="16.65" y1="16.65" x2="21" y2="21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                    </svg>

                </button>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-10">
            <!-- Left Column: User List -->
            <div>
                <div class="bg-gray-700 text-white font-semibold rounded-t px-4 py-2">List of Staff</div>
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
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a7 7 0 00-7 7v3.5l-1.26 2.52A1 1 0 005 17h14a1 1 0 00.86-1.48L18 12.5V9a7 7 0 00-7-7zm1 16h-2a2 2 0 004 0h-2z"></path>
                    </svg>
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
                                    <button class='accept-button mr-2'>Accept</button>
                                    <button class='decline-button'>Decline</button>
                                </div>
                              </div>";
                    }
                    ?>
                </div>
            </div>

            <!-- Right Column: User Actions -->
            <div>
                <div class="bg-gray-700 text-white font-semibold rounded-t px-4 py-2">Manage Staff</div>
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
    <?php include '../includes/footer.php'; ?>
    </div>


</body>
</html>