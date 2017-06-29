<?php 

/*

CREATE DATABASE PLF;

CREATE TABLE testdata (
    `Product Code` varchar(255),
    `Product Name` varchar(255),
    `Product Description` varchar(255),
    `Stock` varchar(255),
    `Cost in GBP` varchar(255),
    `Discontinued` varchar(255)
);
 * PLF TestData Upload Script

 */


//error_reporting(E_ALL);
//ini_set('display_errors', 1);


$servername = "localhost";
$username = "root";
$password = "root";
$db = "PLF";

//database connection details
$connect = mysql_connect($servername,$username,$password);

if (!$connect) {
 die('Could not connect to MySQL: ' . mysql_error());
}

//your database name
$cid =mysql_select_db($db,$connect);

// Name of your CSV file
$csv_file = "stock.csv"; 

// Clear out the DB first
$trunc = "TRUNCATE TABLE `testdata`";
$dropdata = mysql_query($trunc , $connect );


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


    // SQL Query to insert data into DataBase
    $query = "INSERT INTO `testdata`(
                          `Product Code`,
                          `Product Name`,
                          `Product Description`, 
                          `Stock`, 
                          `Cost in GBP`, 
                          `Discontinued`
                          ) 
                                        VALUES( '".$col1."',
                                                '".$col2."',
                                                '".$col3."',
                                                '".$col4."',
                                                '".$col5."',
                                                '".$col6."'
                                                )";
    $s = mysql_query($query, $connect );
    //echo "Data Inserted"."<br />";
     }
        fclose($handle);
}

echo "Execution Complete!!";

mysql_close($connect);


?>
