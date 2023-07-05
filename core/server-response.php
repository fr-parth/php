<?php

	include('conn.php');
      $report="";
       $id=$_SESSION['id'];
            $results=mysql_query("select * from tbl_school_admin where id=".$id."");
           $result=mysql_fetch_array($results);
		   
          $sc_id=$result['school_id'];


	/*
	 * Script:    DataTables server-side script for PHP and MySQL
	 * Copyright: 2010 - Allan Jardine
	 * License:   GPL v2 or BSD (3-point)
	 */
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array('student_id', 'teacher_ID', 'subjcet_code', 'subjectName','Semester_id','Branches_id','batch_id');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id";
	
	/* DB table to use */
	$sTable = "tbl_student_subject_master";
	
	/* Database connection information */

	$gaSql['user']       = "SmartCookies";
     $gaSql['password']   = "Bpsi@1234";
     $gaSql['db']         = "SmartCookies";
     $gaSql['server']     = "SmartCookies.db.7121184.hostedresource.com";
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * MySQL connection
	 */
	$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
		die( 'Could not open connection to server' );
	
	mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
		die( 'Could not select database '. $gaSql['db'] );
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		where school_id='$sc_id'
		$sOrder
		$sLimit
	";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "version" )
			{
				/* Special output formatting for 'version' column */
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				$row[] = $aRow[ $aColumns[$i] ];
			}
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>




<?php
/*include("conn.php");

$id=$_SESSION['id'];
      $query=mysql_query("select school_id from tbl_school_admin where id='$id'");
	  $result=mysql_fetch_array($query);

$sc_id=$result['school_id'];
$page=$_POST['page'];
$length=$_POST['length'];
$recordsDisplay=$_POST['recordsDisplay'];

$i=1;
	$Sql=mysql_query("select s.std_name,s.std_Father_name ,s.std_lastname,st.student_id,st.subjcet_code,st.subjectName,st.Semester_id,st.Branches_id from tbl_student_subject_master st, tbl_student s where st.school_id='$sc_id' and s.std_PRN=st.student_id LIMIT $page,$length");
	          
							while($test=mysql_fetch_assoc($Sql))
							{
							
							$student_id=$test['student_id'];
							
							$std_name=$test['std_name']." ".$test['std_Father_name']." ".$test['std_lastname'];
							
							
							$subjcet_code=$test['subjcet_code'];
							$subjectName=$test['subjectName'];
							$Semester_id=$test['Semester_id'];
							$Branches_id=$test['Branches_id'];
						
                            
							
						
							
		$data[]= array('sr_no'=>$i,'student_id'=>$student_id,'std_name'=>$std_name,'subjcet_code'=>$subjcet_code,'subjectName'=>$subjectName,'Semester_id'=>$Semester_id,'Branches_id'=>$Branches_id);
							
				$i++;
			 
			 }
			 $getcount=mysql_query("select school_id from tbl_student_subject_master where school_id='$sc_id'");
			        $getrows=mysql_num_rows($getcount);
					      // $count=$getrows['school_id']
                   
    $results = array(
            "drow" =>10,
        "recordsTotal" => $length,
        "recordsFiltered" => $length,
		"iTotalPages"=>50,
          "aaData"=>$data);
/*while($row = $result->fetch_array(MYSQLI_ASSOC)){
  $results["data"][] = $row ;
}

echo json_encode($results);*/

?>