<?php
	include ("conn.php");
	class smartcookie
	{
		//for insert product name and how many points per product
		function insertproduct($Sponser_product, $school_id, $points_per_product, $sponsered_date, $valid_no_of_student)
		{
		  mysql_query("insert into tbl_sponsored (`Sponser_type`,`Sponser_product`,`school_id`,`points_per_product`,`sponsered_date`,`valid_no_of_student`) values ('Product','$Sponser_product','$school_id','$points_per_product','$sponsered_date','$valid_no_of_student')");
		  header("Location:sponsorer.php");
		}
		
		//for insert discount on product and points per discount
		function insertproductdiscount($Sponser_product, $school_id, $points_per_product, $sponsered_date, $valid_no_of_student)
		{
			mysql_query("insert into tbl_sponsored (`Sponser_type`,`Sponser_product`,`school_id`,`points_per_product`,`sponsered_date`,`valid_no_of_student`) values ('discount','$Sponser_product','$school_id','$points_per_product','$sponsered_date','$valid_no_of_student')");
			 header("Location:sponsorer.php");
		}
		
		//for insert amount and points per dollar
		function insertMoney($Sponser_product, $school_id, $points_per_product, $sponsered_date, $valid_no_of_student)
		{
			mysql_query("insert into tbl_sponsored (`Sponser_type`,`Sponser_product`,`school_id`,`points_per_product`,`sponsered_date`,`valid_no_of_student`) values ('Money','$Sponser_product','$school_id','$points_per_product','$sponsered_date','$valid_no_of_student')");
			 header("Location:sponsorer.php");
		}
		
		
		/*//retrive name of school admin
		function retrive_scadmin_profile() 
			{
				$sqls=mysql_query("select * from tbl_school_admin where id=".$_SESSION['id']);
		  
				  $results = mysql_fetch_array( $sqls);
		  			return $results;
			
			}*/
		//retrive all teachers profile
		function  teacher_profile()
		{
		  $sql1=mysql_query("select * from tbl_teacher ORDER BY id");
		  
		  $result1 = mysql_fetch_array( $sql1);
		  return $result1;
		  
		    
		}	
		
		
		//retrive   Information
		function retrive_individual($table,$fields) 
		{
		   $para="";
		   $sql="";
	              $sql="select * from $table where ";
				  $count=count($fields);
				  $i=0;
				  foreach($fields as $field=>$value)
				  {
				  if($i==$count-1)
				  {
				 
				  $para.="".$field."". "= " ."'".$value."'";
				  }
				  else
				  {
				  $para.="".$field."". "= " ."'".$value."'"." AND ";
				  }
				  
				  }
				 $sql.=$para;
				return mysql_query($sql);
				  
		   
				 
					 
		}
	}
?>