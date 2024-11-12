<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage IP Assets</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adminMpa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body class="bg-gray-100">

    <?php include '../includes/dashboard.php'; ?>
    <?php include '../includes/header.php'; ?>

    <div class="dashboard p-10">
        <h2 class="text-2xl font-semibold text-gray-700 mb-8">Manage IP Assets</h2>

        <!-- Columns Section -->
        <div class="grid grid-cols-3 gap-5">
            <!-- Statement of Account Column -->
            <div class="bg-white rounded-lg shadow-md p-5">
                <div class="text-center bg-blue-900 text-white font-bold py-2 rounded">Statement Of Account</div>
                <ul class="mt-4 space-y-2">
                    <!-- Static PDF Sample with Enhanced Download Icon -->
                    <li class="bg-blue-100 text-blue-600 p-2 rounded flex justify-between items-center">
                        <a href="uploads/soa/sample.pdf" target="_blank">sample_soa.pdf</a>
                        <a href="uploads/soa/sample.pdf" download>
                            <div class="p-2 rounded-full bg-blue-600 hover:bg-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z" /> <!-- White box outline -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v6m0 0l-3-3m3 3l3-3" /> <!-- Centered downward arrow -->
                                </svg>
                            </div>
                        </a>
                    </li>
                </ul>
                <form action="" method="POST" enctype="multipart/form-data" class="mt-5">
                    <input type="file" name="fileToUpload" id="fileToUpload_soa" class="hidden" onchange="this.form.submit()">
                    <button type="button" onclick="document.getElementById('fileToUpload_soa').click()" name="upload_soa" class="w-full bg-yellow-500 text-white py-2 rounded-lg font-bold hover:bg-yellow-600">ADD / UPLOAD SOA</button>
                </form>
            </div>

            <!-- OR Column -->
            <div class="bg-white rounded-lg shadow-md p-5">
                <div class="text-center bg-blue-900 text-white font-bold py-2 rounded">OR</div>
                <ul class="mt-4 space-y-2">
                    <!-- Static PDF Sample with Enhanced Download Icon -->
                    <li class="bg-blue-100 text-blue-600 p-2 rounded flex justify-between items-center">
                        <a href="uploads/or/sample.pdf" target="_blank">sample_or.pdf</a>
                        <a href="uploads/or/sample.pdf" download>
                            <div class="p-2 rounded-full bg-blue-600 hover:bg-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z" /> <!-- White box outline -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v6m0 0l-3-3m3 3l3-3" /> <!-- Centered downward arrow -->
                                </svg>
                            </div>
                        </a>
                    </li>
                </ul>
                <form action="" method="POST" enctype="multipart/form-data" class="mt-5">
                    <input type="file" name="fileToUpload" id="fileToUpload_or" class="hidden" onchange="this.form.submit()">
                    <button type="button" onclick="document.getElementById('fileToUpload_or').click()" name="upload_or" class="w-full bg-blue-500 text-white py-2 rounded-lg font-bold hover:bg-blue-600">ADD / UPLOAD OR</button>
                </form>
            </div>

            <!-- Formality Report Column -->
            <div class="bg-white rounded-lg shadow-md p-5">
                <div class="text-center bg-blue-900 text-white font-bold py-2 rounded">Formality Report</div>
                <ul class="mt-4 space-y-2">
                    <!-- Static PDF Sample with Enhanced Download Icon -->
                    <li class="bg-blue-100 text-blue-600 p-2 rounded flex justify-between items-center">
                        <a href="uploads/formality/sample.pdf" target="_blank">sample_formality.pdf</a>
                        <a href="uploads/formality/sample.pdf" download>
                            <div class="p-2 rounded-full bg-blue-600 hover:bg-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z" /> <!-- White box outline -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v6m0 0l-3-3m3 3l3-3" /> <!-- Centered downward arrow -->
                                </svg>
                            </div>
                        </a>
                    </li>
                </ul>
                <form action="" method="POST" enctype="multipart/form-data" class="mt-5">
                    <input type="file" name="fileToUpload" id="fileToUpload_formality" class="hidden" onchange="this.form.submit()">
                    <button type="button" onclick="document.getElementById('fileToUpload_formality').click()" name="upload_formality" class="w-full bg-yellow-500 text-white py-2 rounded-lg font-bold hover:bg-yellow-600">ADD / UPLOAD FORMALITY REPORT</button>
                </form>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
