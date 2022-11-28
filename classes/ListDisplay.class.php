<?php
 include_once('DBConn.class.php');
class listDisplay extends DBConn{
	
public function total_pages($total_rows, $rows_per_page) {
    if ( $total_rows < 1 ) $total_rows = 1;
    return ceil($total_rows/$rows_per_page);
}

public function page_to_row($current_page, $rows_per_page) {
    $start_row = ($current_page-1) * $rows_per_page + 1;
    return $start_row;
}

function count_rows($table, $condition) {
     return $this->countLazySelect($table,$condition);
}

function sum_topups(){
	$sumcol = "TR_AMOUNT";
	$tables = array("transactions");
	$condition = "where tr_type = 1 and tr_status = 1";
	return @$this -> complexSum($sumcol, $tables, $condition);
}

function sum_payments(){
	$sumcol = "TR_AMOUNT";
	$tables = array("transactions");
	$condition = "where tr_type = 2 and tr_status = 1";
	return @$this -> complexSum($sumcol, $tables, $condition);
}
public function draw_pager($url, $total_pages, $current_page) {
 
    if ( $current_page <= 0 || $current_page > $total_pages ) {
        $current_page = 1;
    }
 
    if ( $current_page > 1 ) {
        printf( "<a href='$url?page=%d'>[Start]</a> \n" , 1);
        printf( "<a href='$url?page=%d'>[Prev]</a> \n" , ($current_page-1));
    }
 
    for( $i = ($current_page-3); $i <= $current_page+3; $i++ ) {
 
        if ($i < 1) continue;
        if ( $i > $total_pages ) break;
 
        if ( $i != $current_page ) {
            printf( "<a href='$url?page=%1\$d' style=\"color:#0000CC\">%1\$d</a> \n" , $i);
        } else {
            printf("<a href='$url?page=%1\$d' style=\"color: #FF0000\"><strong>%1\$d</strong></a> \n",$i);
        }
 
    }
 
    if ( $current_page < $total_pages ) {
        printf( "<a href='$url?page=%d'>[Next]</a> \n" , ($current_page+1));
        printf( "<a href='$url?page=%d'>[End]</a> \n" , $total_pages);
    }
 
}
	public function paged_result($table,$condition,$start = null, $end = null) {
	   return $this->simpleLazySelect($table, $condition);
	
	}
}
?>