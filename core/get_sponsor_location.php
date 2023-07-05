<?php
    include('conn.php');
    require 'configs.php';
     
    try {
      
		$dist=$_GET['dist'];
		$lat1=$_GET['latitude'];
		 $lon1=$_GET['longitude'];
		 $id=$_SESSION['id'];
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$unit="K";
		$j=0;
		/*$student=mysql_query("select id,latitude ,longitude from tbl_student where id='$stud_id' ");
	     $student_address=mysql_fetch_array($student);
	   $lat1=$student_address['latitude'];
		 $lon1=$student_address['longitude'];*/
		
		 $sponsor=mysql_query("select id,lat ,lon from tbl_sponsorer where id!=$id");
		
		 $i=0;
		 $locations=array(array());
		
        	while( $sponsor_address=mysql_fetch_array($sponsor))
			{ 
			$lat1=$_GET['latitude'];
		 $lon1=$_GET['longitude'];
				 $lat2[$i]=$sponsor_address['lat'];
				
				 $lon2[$i]=$sponsor_address['lon'];
			
			   $sp_id[$i]=$sponsor_address['id'];
			
				 $pi80 = M_PI / 180;
					$lat1 *= $pi80;
					$lon1 *= $pi80;
					$lat2[$i] *= $pi80;
					$lon2 [$i]*= $pi80;
 
					$r = 6372.797; // mean radius of Earth in km
					$dlat[$i] = $lat2[$i] - $lat1;
					$dlng[$i] = $lon2[$i]- $lon1;
					$a = sin($dlat[$i] / 2) * sin($dlat[$i] / 2) + cos($lat1) * cos($lat2[$i]) * sin($dlng[$i]/ 2) * sin($dlng[$i] / 2);
					$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
					
		        $distance[$i]= $r * $c;
			
		
			 
					 if($distance[$i]<$dist)
					  {
	       $sp_id[$i]=$sponsor_address['id'];

				  $sth = $db->query("SELECT id, sp_name as name,sp_address as address, lat,lon, sp_email as description FROM tbl_sponsorer where id='$sp_id[$i]'");
				 //  $sth = $db->query("SELECT * FROM locations");
					 $locations[$j] = $sth->fetchAll();
				    
					$j++;
					}
				 $i++;
				 
		}
	
		if(count($locations)>0)
		{
       echo json_encode($locations);
		}
		
         
    } catch (Exception $e) {
        echo $e->getMessage();
    }