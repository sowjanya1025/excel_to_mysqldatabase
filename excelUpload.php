<?php

  error_reporting(0); // shwoing warnings Warning: "continue" targeting switch is equivalent to "break". Did you mean to use "continue 2"? 
require('library/php-excel-reader/excel_reader2.php');

require('library/SpreadsheetReader.php');

require('dbConfig.php');
//echo $_FILES["file"]["type"];

if(isset($_POST['Submit'])){


  $mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  if(in_array($_FILES["file"]["type"],$mimes)){


    $uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);

    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);


    $Reader = new SpreadsheetReader($uploadFilePath);


    $totalSheet = count($Reader->sheets());


    echo "You have total ".$totalSheet." sheets".


    $html="<table border='1'>";

    $html.="<tr><th>Title</th><th>Description</th></tr>";


    /* For Loop for all sheets */

    for($i=0;$i<$totalSheet;$i++){


      $Reader->ChangeSheet($i);


      foreach ($Reader as $Row)

      {
	  
	  	//$arr[] =  $Row[0];
		
		  $title = isset($Row[0]) ? $Row[0] : '';
		  $desc = isset($Row[1]) ? $Row[1] : '';
		$html.="<tr><td>".$title."</td><td>".$desc."</td></tr>";
		
       }
//	   if ( count( $arr ) === count( array_unique( $arr ) ) ) 
//	   {
//	  		 echo "No duplicates";
//			 				echo  $title = isset($Row[0]) ? $Row[0] : '';
//							echo  $desc = isset($Row[1]) ? $Row[1] : '';
//							// $phone = isset($Row[2]) ? $Row[2] : '';
//
//			 //break;
//		}else { echo "some duplicates";}
	 //  print_r($arr);


    }


    $html.="</table>";

    echo $html;

    echo "<br />Data Inserted in dababase";


  }else { 

    die("<br/>Sorry, File type is not allowed. Only Excel file."); 

  }


}


?>