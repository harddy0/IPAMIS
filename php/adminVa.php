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

// Check if a start and end date have been selected
if (isset($_POST['start_month'], $_POST['end_month'], $_POST['end_year'])) {
    $start_month = $_POST['start_month'];
    $end_month = $_POST['end_month'];
    $end_year = $_POST['end_year'];

    // Define start and end dates
    $start_date = "$end_year-$start_month-01";
    $end_date = date("Y-m-t", strtotime("$end_year-$end_month-01")); // Last day of the end month

    // Query the database for the selected date range
    $stmt = $conn->prepare("
        SELECT application_type, COUNT(*) AS count 
        FROM invention_disclosure 
        WHERE date_submitted BETWEEN ? AND ? 
        GROUP BY application_type
    ");
    $stmt->bind_param("ss", $start_date, $end_date);
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
    <title>Admin View Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
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
            <div class="main-content p-6">
                <div class="container mx-auto">
                    <!-- Analytics Header -->
                    <h1 class="text-2xl font-bold mb-4 flex items-center">
                        <span class="mr-1"><i class="fas fa-chart-pie"></i></span> View Analytics
                    </h1>

                    <!-- Date Range Selection Form -->
                    <form method="POST" class="mb-6 flex space-x-4">
                        <div>
                            <label for="start_month" class="block text-gray-700">Start Month:</label>
                            <select id="start_month" name="start_month" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2">
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo $m; ?>" <?php echo (isset($start_month) && $start_month == $m) ? 'selected' : ''; ?>>
                                        <?php echo date('F', mktime(0, 0, 0, $m, 10)); ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <label for="end_month" class="block text-gray-700">End Month:</label>
                            <select id="end_month" name="end_month" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2">
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo $m; ?>" <?php echo (isset($end_month) && $end_month == $m) ? 'selected' : ''; ?>>
                                        <?php echo date('F', mktime(0, 0, 0, $m, 10)); ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <label for="end_year" class="block text-gray-700">Year:</label>
                            <select id="end_year" name="end_year" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2">
                                <?php for ($y = date("Y"); $y >= 2000; $y--): ?>
                                    <option value="<?php echo $y; ?>" <?php echo (isset($end_year) && $end_year == $y) ? 'selected' : ''; ?>>
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
                            <h2 class="text-lg font-semibold mt-24">
                                Analytics for Selected Date Range
                            </h2>
                            <canvas id="pieChart"></canvas>
                        </div>                        

                        
                        <!-- Data Boxes Container -->
                        <div class="data-boxes-container grid grid-cols-1 gap-4 md:grid-cols-2">
                            <?php 
                            // Define color mappings to match chart colors
                            $colors = [
                                'Patent (Invention)' => '#FF6384', 
                                'Industrial Design' => '#36A2EB', 
                                'Utility Model' => '#FFCE56', 
                                'Trademark' => '#4BC0C0', 
                                'Copyright' => '#9966FF', 
                                'Trade Secret' => '#FF9F40', 
                                'Geographical Indication' => '#FF6384'
                            ];

                            foreach ($applicationCounts as $type => $count): 
                                $color = $colors[$type]; // Get the color for each type
                            ?>
                                <div class="data-box rounded-lg shadow-md p-4 flex flex-col items-center" style="background-color: <?php echo $color; ?>;">
                                    <span class="text-white font-semibold"><?php echo $type; ?></span>
                                    <span class="data-value text-2xl font-bold"><?php echo $count; ?></span>
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
    // Access the canvas element
    const ctx = document.getElementById('pieChart').getContext('2d');
    
    // Use the application counts from PHP, already calculated and output as JSON
    const applicationCounts = <?php echo $applicationCountsJSON; ?>;
    
    // Calculate the total count of applications to determine percentages
    const totalApplications = applicationCounts.reduce((a, b) => a + b, 0);

    // Initialize the pie chart with percentage labels inside each slice
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
                    position: 'left', // Position legend to the left of the chart
                    align: 'center',
                    labels: {
                        boxWidth: 20,
                        padding: 10
                    }
                },
                datalabels: {
                    display: true, // Ensure data labels are displayed
                    color: '#ffffff', // Set text color to white for contrast
                    anchor: 'center', // Position labels at the center of each slice
                    align: 'center', // Align data labels within the center of each slice
                    formatter: (value) => {
                        // Calculate percentage for each slice
                        const percentage = (value / totalApplications * 100).toFixed(1);
                        return percentage + '%'; // Return formatted percentage
                    },
                    font: {
                        weight: 'bold',
                        size: 14 // Font size for readability
                    }
                }
            }
        }
    });
</script>




</body>
</html>
