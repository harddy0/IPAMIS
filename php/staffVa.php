<?php
// Display all errors for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';

// Initialize variables for application counts
$applicationCounts = [
    'Patent (Invention)' => 0,
    'Industrial Design' => 0,
    'Utility Model' => 0,
    'Trademark' => 0,
    'Copyright' => 0,
    'Trade Secret' => 0,
    'Geographical Indication' => 0
];

// Check if a month and year have been selected
if (isset($_POST['month']) && isset($_POST['year'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Query the database for the selected month and year
    $stmt = $conn->prepare("SELECT application_type, COUNT(*) AS count FROM invention_disclosure WHERE MONTH(date_submitted) = ? AND YEAR(date_submitted) = ? GROUP BY application_type");
    $stmt->bind_param("ii", $month, $year);
    $stmt->execute();
    $result = $stmt->get_result();

    // Update the application counts based on the query result
    while ($row = $result->fetch_assoc()) {
        $type = $row['application_type'];
        if (isset($applicationCounts[$type])) {
            $applicationCounts[$type] = $row['count'];
        }
    }

    $stmt->close();
}

// Convert PHP array to JSON for use in JavaScript
$applicationCountsJSON = json_encode(array_values($applicationCounts));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff View Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            <?php include '../includes/dashboard_staff.php'; ?>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper ml-64 flex-grow overflow-y-auto">
            <!-- Header -->
            <?php include '../includes/header.php'; ?>

            <!-- Main Content -->
            <div class="main-content p-6">
                <div class="container mx-auto">
                    <!-- Analytics Header -->
                    <h1 class="text-2xl font-bold mb-4 flex items-center">
                        <span class="mr-2"><i class="fas fa-chart-pie"></i></span> View Analytics
                    </h1>

                    <!-- Date Selection Form -->
                    <form method="POST" class="mb-6 flex space-x-4">
                        <div>
                            <label for="month" class="block text-gray-700">Select Month:</label>
                            <select id="month" name="month" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2">
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo $m; ?>" <?php echo (isset($month) && $month == $m) ? 'selected' : ''; ?>>
                                        <?php echo date('F', mktime(0, 0, 0, $m, 10)); ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <label for="year" class="block text-gray-700">Select Year:</label>
                            <select id="year" name="year" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2">
                                <?php for ($y = date("Y"); $y >= 2000; $y--): ?>
                                    <option value="<?php echo $y; ?>" <?php echo (isset($year) && $year == $y) ? 'selected' : ''; ?>>
                                        <?php echo $y; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600">View</button>
                        </div>
                    </form>

                    <!-- Content Box for Graph and Data Boxes -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 content-box">
                        <!-- Graph Container -->
                        <div class="graph-container bg-white rounded-lg shadow-md p-5">
                            <h2 class="text-lg font-semibold mb-4">
                                Analytics for <?php echo isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'Month'; ?> <?php echo isset($year) ? $year : ''; ?>
                            </h2>
                            <canvas id="pieChart"></canvas>
                        </div>

                        <!-- Data Boxes Container -->
                        <div class="data-boxes-container grid grid-cols-1 gap-4 md:grid-cols-2">
                            <?php foreach ($applicationCounts as $type => $count): ?>
                                <div class="data-box bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
                                    <span class="text-gray-700 font-semibold"><?php echo $type; ?></span>
                                    <span class="data-value text-2xl font-bold text-blue-500"><?php echo $count; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <?php include '../includes/footer.php'; ?>
            
        </div>
    </div>


<!-- Chart.js Script -->
<script>
    const ctx = document.getElementById('pieChart').getContext('2d');
    const applicationCounts = <?php echo $applicationCountsJSON; ?>;

    const pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [
                'Patent (Invention)', 
                'Industrial Design', 
                'Utility Model', 
                'Trademark', 
                'Copyright', 
                'Trade Secret', 
                'Geographical Indication'
            ],
            datasets: [{
                data: applicationCounts,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FF6384'
                ],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

</body>
</html>