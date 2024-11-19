<?php
// Display all errors for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';

// Initialize variables for application counts
$applicationCounts = [
    'Patent' => 0,
    'Industrial Design' => 0,
    'Utility Model' => 0,
    'Trademark' => 0,
    'Copyright' => 0,
    'Trade Secret' => 0,
    'Geographical Indication' => 0
];

// Default start and end dates
$default_start_date = '2024-01-01';
$default_end_date = '2024-12-31';

// Check if a start and end date have been selected
if (isset($_POST['start_date'], $_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
} else {
    // Use default date range if none selected
    $start_date = $default_start_date;
    $end_date = $default_end_date;
}

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

// Calculate total applications
$totalApplications = array_sum($applicationCounts);

// Calculate percentages for each type
$applicationPercentages = [];
foreach ($applicationCounts as $type => $count) {
    $applicationPercentages[$type] = ($totalApplications > 0) ? round(($count / $totalApplications) * 100, 1) : 0;
}

// Convert PHP arrays to JSON for JavaScript
$applicationCountsJSON = json_encode(array_values($applicationCounts));
$applicationPercentagesJSON = json_encode(array_values($applicationPercentages));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/adminVa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                    <h1 class="text-3xl font-bold text-blue-900 mb-6 flex items-center">
                        <span class="mr-1"><i class="fas fa-chart-pie"></i></span> View Analytics
                    </h1>

                    <!-- Date Range Selection Form -->
                    <form method="POST" class="mb-6 flex space-x-4 items-end">
                        <div>
                            <label for="start_date" class="block text-gray-700">Start Date:</label>
                            <input type="text" id="start_date" name="start_date" value="2024-01-01" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2">
                        </div>
                        <div>
                            <label for="end_date" class="block text-gray-700">End Date:</label>
                            <input type="text" id="end_date" name="end_date" value="2024-12-31" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2">
                        </div>
                        <div>
                            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600">View</button>
                        </div>
                    </form>

                    <h2 class="text-lg font-semibold mt-12">
                        Analytics for Selected Date Range
                    </h2>
                    <!-- Content Box for Graph and Data Boxes -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 content-box">
                        <!-- Graph Container -->
                        <div class="graph-container bg-white rounded-lg shadow-md"> 
                            <canvas id="pieChart"></canvas>
                        </div>

                        <!-- Data Boxes Container -->
                        <div class="data-boxes-container grid grid-cols-1 gap-4 md:grid-cols-2">
                            <?php 
                            $colors = [
                                'Patent' => '#FF6384', 
                                'Industrial Design' => '#36A2EB', 
                                'Utility Model' => '#FFCE56', 
                                'Trademark' => '#4BC0C0', 
                                'Copyright' => '#9966FF', 
                                'Trade Secret' => '#FF9F40', 
                                'Geographical Indication' => '#FF6384'
                            ];

                            foreach ($applicationCounts as $type => $count): 
                                $color = $colors[$type];
                                $percentage = $applicationPercentages[$type];
                            ?>
                                <div class="data-box rounded-lg shadow-md p-4 flex flex-col items-center justify-center text-center" 
                                    style="background-color: <?php echo $color; ?>; min-height: 100px; padding: 16px;">
                                    <span class="text-white font-semibold" style="font-size: 1.1rem;"><?php echo $type; ?></span>
                                    <span class="data-value text-2xl font-bold text-white" style="font-size: 1.6rem;">
                                        <?php echo $count; ?> 
                                        <span style="font-size: 0.8rem; font-weight: normal;">(<?php echo $percentage; ?>%)</span>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                     <!-- Custom Legend Container -->
                    <div class="legend-container">
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #FF6384;"></span>
                            Patent (Invention)
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #36A2EB;"></span>
                            Industrial Design
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #FFCE56;"></span>
                            Utility Model
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #4BC0C0;"></span>
                            Trademark
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #9966FF;"></span>
                            Copyright
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #FF9F40;"></span>
                            Trade Secret
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #FF6384;"></span>
                            Geographical Indication
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>

<!-- Flatpickr and Chart.js Script -->
<script>
    // Initialize Flatpickr for Start Date and End Date
    const startDatePicker = flatpickr('#start_date', {
        defaultDate: "2024-01-01",
        dateFormat: 'Y-m-d',
        onChange: function (selectedDates, dateStr, instance) {
            endDatePicker.set('minDate', dateStr); // Ensure end date is after start date
        }
    });

    const endDatePicker = flatpickr('#end_date', {
        defaultDate: "2024-12-31",
        dateFormat: 'Y-m-d',
        onChange: function (selectedDates, dateStr, instance) {
            startDatePicker.set('maxDate', dateStr); // Ensure start date is before end date
        }
    });

    // Generate the Pie Chart
    const ctx = document.getElementById('pieChart').getContext('2d');
    const applicationCounts = <?php echo $applicationCountsJSON; ?>;
    const totalApplications = applicationCounts.reduce((a, b) => a + b, 0);

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
                    display: false, // Disable the default legend
                },
                datalabels: {
                    display: true,
                    color: '#ffffff',
                    formatter: (value) => {
                        const percentage = (value / totalApplications * 100).toFixed(1);
                        return percentage + '%';
                    },
                    font: {
                        weight: 'bold',
                        size: 14
                    }
                }
            }
        }
    });
</script>
</body>
</html>
