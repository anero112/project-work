<?php
// session_start();
include('header.php');

// Fetch customers from the database
$query = "SELECT * FROM tbl_customer ORDER BY cust_name ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$customers = $stmt->fetchAll();
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Customer Reports</h1>

    <div class="table-responsive" id="printSection">
        <h2 class="text-center print-title">Customer Report</h2>
        <table class="table table-bordered print-table" id="reportTable">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Full Name</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Billing Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $row) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['cust_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['cust_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['cust_cname']); ?></td>
                        <td><?php echo htmlspecialchars($row['cust_email']); ?></td>
                        <td><?php echo htmlspecialchars($row['cust_phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['cust_b_address']); ?></td>
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
        button {
            display: none !important; /* Hide buttons when printing */
        }
    }
</style>

<script>
    function printReport() {
        window.print();
    }
</script>

<?php include('footer.php'); ?>
