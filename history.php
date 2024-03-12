<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>DNA Sequence Result</title>
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600&display=swap" rel="stylesheet">
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />

<!-- Include DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<!-- Include DataTables JavaScript -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<!-- Include PapaParse JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

<!-- Style for Footer -->
<style>
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: lightgray;
   color: black;
   text-align: center;
}
/* Header */
.header {
   /* background-color: #007bff;*/
    color: #fff;
    padding: 40px 0;
    display: flex;
    justify-content: space-between;
    background: #83A2FF url(images/overlay.png) repeat;
    align-items: center;
}

/* Logo */
.left-logo,
.right-logo {
    flex: 1; /* Equal width for logos */
}

.center-title {
    flex: 2; /* Twice the width of logos */
}

.header img {
    height: 150px;
}

/* Menu or Navigation Bar */
#menu {
/*    transition: 0.3s;  */
 /*   padding: 0em 1.5em; */
 /*   text-decoration: none; */
  /*  font-size: 0.90em;  */
 /*   font-weight: 300;   */
  /*  text-transform: uppercase;  */
  /*  line-height: 5px; */   
  background-color: #333; /* Example background color */
    color: #fff;
    padding: 5px 0;
    text-align: center;
}

#menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

#menu ul li {
    display: inline;
    margin-right: 20px; /* Adjust as needed */
}

#menu ul li:last-child {
    margin-right: 0; /* Remove margin for the last item */
}

#menu ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
}


.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: lightgray;
   color: black;
   text-align: center;
}

</style>

</head>
<body>
<body>
    <!-- Header -->
    <div class="header">
        <div>
            <img style="height:150px;" src="images/crab_logo.png" class="rounded float-left" alt="LOGO">
        </div>
        <div class="text-center">
	<h1 class="text-center" style="font-size: 2.5rem; color: white;">
             ORMT: OPT mRNA Prediction Tool
            </h1>
        </div>  
        <div>
            <img style="height:150px;" src="images/imtech_logo.png" class="rounded float-right" alt="IMTECH_LOGO">
        </div>
    </div>

    <!-- Menu or Navigation Bar -->
    <div id="menu">
        <ul>
            <li><a href="index.html" accesskey="1" title="">Home</a></li>
            <li><a href="test.php" accesskey="2" title="">Test Your Sequence</a></li>
            <li><a href="search.php" accesskey="3" title="">Previous Job Results</a></li>
            <li><a href="#" accesskey="4" title="">Reference</a></li>
            <li><a href="#" accesskey="5" title="">Help</a></li>
        </ul>
    </div>
</body>

<h2>Search Results</h2>
<?php
// Check if the form is submitted
$jobId=isset($_POST['job_id']) ? $_POST['job_id'] : '';

$csvFilePath = "results/{$jobId}_total_output_sample_data_mrna.csv";

// Check if the file exists
if(!file_exists($csvFilePath)) {
    die("No result file found for Job ID: $jobId.");
    exit;
}
?>

<table id='resultTable' border='1'>
<?php
if (($handle = fopen($csvFilePath, "r")) !== FALSE) {
    $header = fgetcsv($handle, 1000, ",");
    echo "<thead><tr>";
    foreach ($header as $columnName) {
        echo "<th>$columnName</th>";
    }
    echo "</tr></thead><tbody>";

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        echo "<tr>";
        foreach ($data as $cell) {
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    fclose($handle);
} else {
    echo "Error: Unable to open CSV file.";
}
?>
</table>

<a href='<?php echo $csvFilePath; ?>' download>Download CSV</a>

<script>
$(document).ready( function () {
    $('#resultTable').DataTable({
        lengthMenu: [ [10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"] ],
        searching: true,
        paging: true,
        ordering: true,
        orderCellsTop: true,
        bInfo: true,
        scrollY: 400,
        scrollCollapse: true,
        columns: [
            // Define your columns here
            <?php
            if (($handle = fopen($csvFilePath, "r")) !== FALSE) {
                $header = fgetcsv($handle, 1000, ",");
                $columnDefs = '';
                foreach ($header as $columnName) {
                    $columnDefs .= "{ data: '$columnName' },";
                }
                fclose($handle);
                echo $columnDefs;
            }
            ?>
        ],
        columnDefs: [
            { type: 'num', targets: [3, 4, 5] } // Indices start from 0
        ]
    });
});
</script>

<!-- Footer -->
<div class="footer">
  <p>All rights reserved. being modified by somnath, BIC, CSIR-IMTECH</p>
</div>

</body>
</html>
