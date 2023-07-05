<?php
	
	class school
	{
	  //retrive class of particular school
		function  retriveclass($sc_id)
		{
		  $sql=mysql_query("select * from tbl_class where school_id='$sc_id' and teacher_id='0' ORDER BY class");
		  
		  
		  return $sql;
		  
		    
		}
		function  retrivesubject($school_id)
		{
		  $sql=mysql_query("select * from tbl_subject where school_id='$school_id' and teacher_id=0 ORDER BY subject");
		  
		  
		  return $sql;
		  
		    
		}
		function  retriveactivity($school_id)
		{
		  $sql=mysql_query("select * from  tbl_studentpointslist where school_id='$school_id'  ORDER BY sc_list");
		  
		  
		  return $sql;
		  
		    
		}
	
	
	}
	
	?>