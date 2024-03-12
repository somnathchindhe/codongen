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

/* DataTables Styles */
.dataTables_wrapper {
    width: 90%;
    margin: 0 auto;
    padding-top: 2em;
}

table.dataTable thead th, table.dataTable thead td {
    padding: 10px 18px;
    border-bottom: 1px solid #111;
}

table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px 18px;
}

table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td {
    border-top: 1px solid #ddd;
}

.footer {
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

<h2>DNA Sequence Results</h2>

<?php

// Generate unique ID for this submission
$submissionId = uniqid();

// Get the submitted DNA sequence, fasta file, and email
$dnaSequence = isset($_POST['dnaSequence']) ? $_POST['dnaSequence'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

// Check if a fasta file was uploaded
if(isset($_FILES['fastaFile']) && $_FILES['fastaFile']['error'] === UPLOAD_ERR_OK) {
    $fastaFilePath = $_FILES['fastaFile']['tmp_name'];
    // Read the fasta file content
    $fastaContent = file_get_contents($fastaFilePath);
    // Extract the DNA sequence from the fasta content
    // Assuming the fasta format is ">header\nsequence"
    $lines = explode("\n", $fastaContent);
    $dnaSequence = '';
    foreach($lines as $line) {
        if(strpos($line, '>') !== false) // Skip header lines
            continue;
        $dnaSequence .= trim($line);
    }
}

if (substr($dnaSequence, 0, 1) === '>') {
    // It seems like FASTA format, extracting sequence
    $lines = explode("\n", $dnaSequence);
    $dnaSequence = '';
    foreach ($lines as $line) {
        if (substr($line, 0, 1) !== '>') {
            $dnaSequence .= trim($line);
        }
    }
}

// Ensure that the sequence length is a multiple of three (i.e., a complete codon)
$sequenceLength = strlen($dnaSequence);
if ($sequenceLength % 3 != 0) {
    die("Sequence length is not a multiple of three (not a complete codon).");
}

// If the sequence is longer than 24 nucleotides, extract the initial 24 nucleotides
if ($sequenceLength > 24) {
    $dnaSequence = substr($dnaSequence, 0, 24);
}

// Convert any incoming sequence in lowercase to uppercase
$dnaSequence = strtoupper($dnaSequence);

echo "Processed DNA Sequence: $dnaSequence<br>";

// Save the DNA sequence to a file with the unique ID
$csvFilePath = "results/{$submissionId}_total_output_sample_data_mrna.csv";

// Run the shell script with DNA sequence as an argument
$scriptPath = "/var/www/html/anshu/codongen/alternate_4.sh";
$output = shell_exec("$scriptPath '$dnaSequence' '$submissionId' 2>&1");

// Check if the script executed successfully
if (!empty($output)) {
    echo "Error executing shell script: $output<br>";
    exit;
}

//echo "Process completed.<br>"

  echo "<p>Your submission has been processed successfully. You can access your results using the following Submission ID:$submissionId</p>";
  echo "<p>**Please note:** This ID will be active for only 48 hours.</p>";
  echo "<p>Click <a href=\"search.php\">here</a> to access your results using your Submission ID.</p>"

?>

<!-- Output the CSV content -->
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

//<script>
//$(document).ready( function () {
  //  $('#resultTable').DataTable({
    //    lengthMenu: [ [10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"] ],
      //  searching: true,
      //  paging: true,
       // ordering: true,
       // columns: [
            // Define your columns here
         //   <?php
           // if (($handle = fopen($csvFilePath, "r")) !== FALSE) {
             //   $header = fgetcsv($handle, 1000, ",");
               // $columnDefs = '';
               // foreach ($header as $columnName) {
                 //   $columnDefs .= "{ data: '$columnName' },";
              //  }
               // fclose($handle);
                //echo $columnDefs;
          //  }
         // ?> //chaeck php
      //  ]
  //  });
//});
//</script>

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

<a href='<?php echo $csvFilePath; ?>' download>Download CSV</a>


<!-- Footer -->
<div class="footer">
  <p>All rights reserved. being modified by somnath, BIC, CSIR-IMTECH</p>
</div>

</body>
</html>
