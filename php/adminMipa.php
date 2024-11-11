<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Manage IP Assets</title>
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

        <?php
            // Handle file upload
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $targetDir = "";
                if (isset($_POST['upload_soa'])) {
                    $targetDir = "uploads/soa/";
                } elseif (isset($_POST['upload_or'])) {
                    $targetDir = "uploads/or/";
                } elseif (isset($_POST['upload_formality'])) {
                    $targetDir = "uploads/formality/";
                }

                if (!empty($targetDir) && isset($_FILES['fileToUpload'])) {
                    $targetFile = $targetDir . basename($_FILES['fileToUpload']['name']);
                    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                    if ($fileType == "pdf" && move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
                        echo "<p class='text-green-500'>File uploaded successfully.</p>";
                    } else {
                        echo "<p class='text-red-500'>Only PDF files are allowed.</p>";
                    }
                }
            }

            // Function to display files in a directory
            function displayFiles($directory) {
                $files = glob("$directory/*.pdf");
                foreach ($files as $file) {
                    $fileName = basename($file);
                    echo "<li class='bg-blue-100 text-blue-600 p-2 rounded'><a href='$file' target='_blank'>$fileName</a></li>";
                }
            }
        ?>

        <!-- Columns Section -->
        <div class="grid grid-cols-3 gap-5">
            <!-- Statement of Account Column -->
            <div class="bg-white rounded-lg shadow-md p-5">
                <div class="text-center bg-blue-900 text-white font-bold py-2 rounded">Statement Of Account</div>
                <ul class="mt-4 space-y-2">
                    <?php displayFiles("uploads/soa"); ?>
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
                    <?php displayFiles("uploads/or"); ?>
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
                    <?php displayFiles("uploads/formality"); ?>
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
