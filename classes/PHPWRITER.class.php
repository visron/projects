<?php

//include_once('DBConn.class.php');
//`US_ID`, `SP_NAME`, `SP_LICENSE`, `SP_COUNTY`, `SP_TOWN`, 
//`SP_PHYSICAL_ADDRESS`, `SP_LONG`, `SP_LAT`, `SP_AVATAR`
$columns = array();
$columns = array("US_ID", "SP_NAME", "SP_LICENSE", "SP_COUNTY", "SP_TOWN",
    "SP_PHYSICAL_ADDRESS", "SP_LONG", "SP_LAT", "SP_AVATAR", "SP_STATUS");

$uniqueColumn = "SP_ID";
$uniqueValue = '$' . $uniqueColumn;
$className = "Services";
$table = 'service_providers';

$columnValues = array();
$columnQuotes = array();

foreach ($columns as $cols) {
    $columnValues[] = '$' . $cols;
    $columnQuotes[] = '"' . $cols . '"';
}

$COLUMNSTRINGS = implode(",", $columns);
$COLUMNVALSSTRINGS = implode(",", $columnValues);
$COLUMNQSTRINGS = implode(",", $columnQuotes);

$count = count($columns);


//echo $COLUMNSTRINGS;

$myfile = fopen("Services_txt.class.php", "w") or die("Unable to open file!");

$txt = '<?php ' . "\n";
$txt .= 'include_once("DBConn.class.php"); ' . "\n";
$txt .= 'class ' . $className . ' extends DBConn {' . "\n";
/* * ****write create function*** */
$txt .= 'function setNew' . $table . '(' . $COLUMNVALSSTRINGS . '){ ' . "\n";
$txt .= '$sql = this->lazyInsert("' . $table . '",array(' . $COLUMNQSTRINGS . '),array(' . $COLUMNVALSSTRINGS . '),""); ' . "\n";
$txt .= 'if($sql){ 
     return $sql; 
   } else{ 
   return false;
  }
 }' . "\n";
/* * *****End of Set Function****** */
/* * ******Update Function********* */
$txt .= 'function update' . $table . '(' . $uniqueValue . ',' . $COLUMNVALSSTRINGS . '){ ' . "\n";
//$txt .= 'function update'.$table.'('$uniqueValue.','.$COLUMNVALSSTRINGS.'){ '."\n";
$txt .= '$sql = $this->lazyUpdate("' . $table . '",array(' . $COLUMNQSTRINGS . '),array(' . $COLUMNVALSSTRINGS . '),"' . $uniqueColumn . '","' . $uniqueValue . '");' . "\n";
$txt .= 'if($sql){
 return true;
 }else{
 return false;
 } }';
/* * ******End of Update******** */
/* * ****Get functions********** */
$txt .= 'function getAll' . $table . '(){' . "\n";
$txt .='return $this->simpleLazySelect("' . $table . '","where ' . $columns[$count - 1] . '= ")';


$txt .= '}
 ?>';
fwrite($myfile, $txt);
fclose($myfile);
?>