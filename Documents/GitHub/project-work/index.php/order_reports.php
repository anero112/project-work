<?php
// session_start();
include('header.php');

// Fetch orders based on filters
$whereClause = "WHERE 1=1";
$params = [];

if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $whereClause .= " AND created_at BETWEEN :start_date AND :end_date";
    $params[':start_date'] = $_GET['start_date'];
    $params[':end_date'] = $_GET['end_date'];
}

$query = "SELECT * FROM tbl_order $whereClause ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$orders = $stmt->fetchAll();
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Order Reports</h1>

    <form method="GET" action="" id="filterForm">
        <div class="row">
            <div class="col-md-4">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control">
            </div>
            <div class="col-md-4">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control">
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>

    <br>

    <div class="table-responsive" id="printSection">
        <h2 class="text-center print-title">Order Report</h2>
        <table class="table table-bordered print-table" id="reportTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $row) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['size']); ?></td>
                        <td><?php echo htmlspecialchars($row['color']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['unit_price']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <button class="btn btn-success" onclick="printReport()">Print Report</button>
</div>

<style>
    @media print {
        body {
            font-family: Arial, sans-serif;
        }
        .container-fluid {
            width: 100%;
            padding: 20px;
        }
        .print-title {
            font-size: 24px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .print-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .print-table th, .print-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .print-table th {
            background-color: #f2f2f2;
        }
        #filterForm, button {
            display: none !important; /* Hide non-essential elements */
        }
    }
</style>

<script>
    function printReport() {
        window.print();
    }
</script>

<?php include('footer.php'); ?>
