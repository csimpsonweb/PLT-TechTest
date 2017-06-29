<?php 



error_reporting(E_ALL);
ini_set('display_errors', 1);


class CsvImporter 
{ 
    private $fp; 
    private $parse_header; 
    private $header; 
    private $delimiter; 
    private $length; 
    //-------------------------------------------------------------------- 
    function __construct($file_name, $parse_header=false, $delimiter="\t", $length=8000) 
    { 
        $this->fp = fopen($file_name, "r"); 
        $this->parse_header = $parse_header; 
        $this->delimiter = $delimiter; 
        $this->length = $length; 
        $this->lines = $lines; 

        if ($this->parse_header) 
        { 
           $this->header = fgetcsv($this->fp, $this->length, $this->delimiter); 
        } 

    } 
    //-------------------------------------------------------------------- 
    function __destruct() 
    { 
        if ($this->fp) 
        { 
            fclose($this->fp); 
        } 
    } 
    //-------------------------------------------------------------------- 
    function get($max_lines=0) 
    { 
        //if $max_lines is set to 0, then get all the data 

        $data = array(); 

        if ($max_lines > 0) 
            $line_count = 0; 
        else 
            $line_count = -1; // so loop limit is ignored 

        while ($line_count < $max_lines && ($row = fgetcsv($this->fp, $this->length, $this->delimiter)) !== FALSE) 
        { 
            if ($this->parse_header) 
            { 
                foreach ($this->header as $i => $heading_i) 
                { 
                    $row_new[$heading_i] = $row[$i]; 
                } 
                $data[] = $row_new; 
            } 
            else 
            { 
                $data[] = $row; 
            } 

            if ($max_lines > 0) 
                $line_count++; 
        } 
        return $data; 
    } 
    //-------------------------------------------------------------------- 

} 

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

$importer = new CsvImporter("stock.csv",true); 
while($data = $importer->get(2000)) {

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
	
} 




?>