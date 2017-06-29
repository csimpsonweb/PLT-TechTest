<?php

//(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');

error_reporting(E_ALL);
ini_set('display_errors', 1);

function InsertData(){

	include "dbSettings.php";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	// Name of your CSV file
	$csv_file = "stock.csv"; 

	// Clear out the DB first
	$trunc = "TRUNCATE TABLE `testdata`";
	$dropdata = mysqli_query($conn, $trunc);

	if (($handle = fopen($csv_file, "r")) !== FALSE) {
	   fgetcsv($handle);
	   echo "File data successfully imported to database!!"; 
	   while (($data = fgetcsv($handle, 9000, ",")) !== FALSE) {
	        $num = count($data);
	        for ($c=0; $c < $num; $c++) {
	          $col[$c] = $data[$c];
	        }

	     $col1 = $col[0];
	     $col2 = $col[1];
	     $col3 = $col[2];
	     $col4 = $col[3];
	     $col5 = $col[4];
	     $col6 = $col[5];
	     $col7 = $col[6];

	$sql = "INSERT INTO testdata (`Product Code`, `Product Name`, `Product Description`, `Stock`, `Cost in GBP`, `Discontinued`)
	VALUES( '".$col1."', '".$col2."', '".$col3."', '".$col4."', '".$col5."', '".$col6."' )";

	if (mysqli_query($conn, $sql)) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	     }
	        fclose($handle);
	}

	mysqli_close($conn);

}
InsertData();

?>