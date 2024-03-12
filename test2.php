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
    padding: 15px 0;
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

/* Style for Footer */
.footer {
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #f8f9fa; /* Light gray background */
   color: #212529; /* Dark text color */
   text-align: center;
   padding: 10px 0; /* Padding around the text */
   font-size: 14px; /* Font size */
}

/* Menu or Navigation Bar */
#menu {
    background-color: #333; /* Dark gray background */
    color: #fff; /* White text color */
    padding: 10px 0; /* Padding around the text */
    text-align: center; /* Center the text */
}

#menu ul {
    list-style: none; /* Remove the default list style */
    margin: 0; /* Remove the default margin */
    padding: 0; /* Remove the default padding */
    display: flex; /* Use flexbox for layout */
    justify-content: center; /* Center the list items horizontally */
}

#menu ul li {
    margin: 0 20px; /* Space between list items */
}

#menu ul li a {
    color: #fff; /* Link color */
    text-decoration: none; /* Remove the default underline */
    font-size: 16px; /* Font size */
    transition: color 0.3s ease; /* Smooth color transition */
}

#menu ul li a:hover {
    color: #007bff; /* Link color on hover */
}

#dnaSequence {
  font-family: Arial, sans-serif;
  font-size: 16px;
  line-height: 1.5;
  color: #333; /* Adjust color as needed */
  background-color: #f9f9f9; /* Adjust background color as needed */
  border: 1px solid #ccc; /* Add border if desired */
  padding: 10px; /* Adjust padding as needed */
  width: 100%; /* Set width to 100% to fill container */
  box-sizing: border-box; /* Include padding and border in width calculation */
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
</style>
<!--end of header, start with main code--->

<body class="d-flex flex-column h-100">
<main role="main" class="flex-shrink-0">
  <div class="container">
    <div>
      <h4 class="display-6" style="font-size: 22pt; font-family: Times New Roman; color: #301A03;"><b>Tool to generate all possible synonymous sequences to find optimum sequence to express in <i>Escherichia coli</i></b></h4>
      <hr>
      <p class="lead" style="font-size: 14pt; text-align: justify; color: #301A03; font-family: Times New Roman;">This tool has been developed to genrate all possible synonymous DNA sequences for expression in E.coli. It evaluates the DNA sequence based on codon usage, GC content, and mRNA fold energy values, to select sequence for efficient gene expression in <i>Escherichia coli</i></p>
      <br>
      <p class="lead" style="font-size: 13pt; text-align: justify; color: #301A03; font-family: Times New Roman;">For more help please visit:
        <a class="btn btn-dark btn-sm" href="team2.php#predict" role="button">Help</a>
      </p>
    </div>
    <hr>

    <div class="wrapper">
    <div id="welcome" class="container">
        <div class="title">
            <h2>Submit Your DNA Sequence</h2>
        </div>
        <form id="dnaForm" action="process_dna8.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm();" style="display: flex; flex-direction: column; align-items: start;">
            <button type="button" onclick="paste_example()">Paste Example Sequence</button>
            <label for="dnaSequence"  style="margin-top: 20px;">Enter DNA Sequence:</label>
            <textarea id="dnaSequence" name="dnaSequence" rows="4" cols="50"></textarea>
            <p>OR</p>
            <label for="fastaFile" style="font-size: 16px; color: #333;  margin-bottom: 10px; style="text-align:center"">Upload Fasta File:</label>
            <input type="file" id="fastaFile" name="fastaFile" accept=".fasta,.fa" style="margin-bottom: 20px;">
            <br>
            <label for="email" style="font-size: 16px; color: #333; margin-bottom: 10px;">Your Email (Optional):</label>
            <input type="email" id="email" name="email" style="margin-bottom: 20px;">
            <br>
            <button type="submit" style="background-color: #007bff; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Submit</button>
        </form>
        <div id="waitMessage" style="display: none; font-size: 16px; color: #333; margin-top: 20px; text-align:center;">Please wait while we process your sequence...</div>
    </div>
</div>

<script type="text/javascript">
    function showWaitMessage() {
        document.getElementById("waitMessage").style.display = "block";
    }

    function paste_example() {
        document.getElementById("dnaSequence").value = ">seq1\nATGATAGATATA";
    }

    function validateForm() {
        var val = document.getElementById("dnaSequence").value;
        if (val === '' && document.getElementById("fastaFile").value === "") {
            alert('Please enter the DNA sequence in FASTA format or choose an input file in FASTA format!!!');
            return false;
        }
        if (val !== '' && val.search(/>/) === -1) {
            alert('Please provide the DNA sequence in FASTA format!!!!!!');
            return false;
        }
        
        var numBlocks = (val.match(/>/g) || []).length;

        if (numBlocks > 1) {
        alert('Your input contains more than one FASTA sequence. Please provide only one sequence.');
        return false;
       }

        if (val !== '') {
            var lines = val.split(">");
            for (var i = 1; i < lines.length; i++) {
                var sequ = lines[i].split("\n");
                sequ.splice(0, 1);
                var onlyseq = sequ.join('').trim();
                if ((onlyseq.search(/>/) === -1) && (onlyseq.length > 2)) {
                    if (onlyseq.search(/[^ATGCatgc]/) !== -1) {
                        alert("Your sequence contains alphabets other than nucleotides");
                        return false;
                    }
                    if (onlyseq.search(/[0-9]/) !== -1) {
                        alert("Please check your sequence since it contains digits. ");
                        return false;
                    }
                    if (onlyseq.search(/[!@#$%^&.*():;\"'?,`~]/) !== -1) {
                        alert("Your sequence contains special characters");
                        return false;
                    }
                    if (onlyseq.search(/\s/) !== -1) {
                        alert("Your sequence contains white spaces");
                        return false;
                    }
                    if (onlyseq.length < 24) {
                        if (onlyseq.length % 3 !== 0) {
                            alert("Your DNA sequence length is less than 24 and it is not a multiple of three.");
                            return false;
                        }
                    }
                }
            }
        }
        showWaitMessage();
        return true;
    }
</script>

<!-- Footer -->
<div class="footer">
  <p>All rights reserved. being modified by somnath, BIC, CSIR-IMTECH</p>
</div>

</body>
</html>
