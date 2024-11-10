<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/adminVa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>

   
    <div class="main-wrapper">
        <!-- Sidebar -->
        <?php include '../includes/dashboard.php'; ?>
        <!-- Content Area -->
        <div class="content-wrapper">
            <!-- Header -->
            <?php include '../includes/header.php'; ?>
            <!-- Main content -->
            <div class="main-content">
                <div class="container mx-auto p-6">
                    <!-- Analytics Header -->
                    <h1 class="text-2xl font-bold mb-4 flex items-center">
                        <span class="mr-2"><i class="fas fa-chart-pie"></i></span> View Analytics
                    </h1>

                    <!-- Flex container for the graph and data boxes -->
                    <div class="content-box">
                        <!-- Graph Container -->
                        <div class="graph-container">
                            <h2 class="text-lg font-semibold mb-4">As of November</h2>
                            <canvas id="pieChart"></canvas>
                        </div>

                        <!-- Data Boxes Container -->
                        <div class="data-boxes-container">
                            <div class="data-box">
                                <span>Patent (Invention)</span>
                                <span class="data-value">30</span>
                            </div>
                            <div class="data-box">
                                <span>Industrial Design</span>
                                <span class="data-value">17</span>
                            </div>
                            <div class="data-box">
                                <span>Trade Secret</span>
                                <span class="data-value">10</span>
                            </div>
                            <div class="data-box">
                                <span>Utility Model</span>
                                <span class="data-value">15</span>
                            </div>
                            <div class="data-box">
                                <span>Copyright</span>
                                <span class="data-value">15</span>
                            </div>
                            <div class="data-box">
                                <span>Geographical Indication</span>
                                <span class="data-value">12</span>
                            </div>
                            <div class="data-box">
                                <span>Trademark</span>
                                <span class="data-value">35</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include '../includes/footer.php'; ?>
    </div>

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('pieChart').getContext('2d');
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
                    data: [30, 17, 15, 35, 15, 10, 12],
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
