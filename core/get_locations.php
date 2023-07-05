<?php
   //$con=mysql_connect("Tsmartcookies.db.7121184.hostedresource.com","Tsmartcookies","B@v!2018297");
  include_once("conn.php");
//mysql_select_db("Tsmartcookies",$con);
    require_once('configs.php');
     
    try {
      
		$dist=$_GET['dist'];
		$lat1=$_GET['latitude'];
		 $lon1=$_GET['longitude'];
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$unit="K";
		$j=0;
		
		 
		  $sp_id=$_GET['sp_id'];
		
		  $sponsor=mysql_query("select id,lat ,lon from tbl_sponsorer where id!='$sp_id' ");
		 
		
		
		 $i=0;
		 $locations=array(array());
		
        	while( $sponsor_address=mysql_fetch_assoc($sponsor))
			{ 
		 $sponsor_address['id'];
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
	           $sp_id1[$i]=$sponsor_address['id'];

			
				  $sth = $db->query("SELECT id, sp_company as name,sp_address as address, lat,lon, sp_phone as description FROM tbl_sponsorer where id='$sp_id1[$i]'");
				 //  $sth = $db->query("SELECT * FROM locations");
					 $locations[$j] = $sth->fetchAll();
				    
					$j++;
					}
				 $i++;
		}
		
		if(isset($_GET['school_id']))
          {
		  $school_id=$_GET['school_id'];

		 $school=mysql_query("select school_mnemonic,school_latitude,school_longitude from tbl_school where school_mnemonic!='$school_id'");
		 }
		 else
		 {
		 
		  $school=mysql_query("select school_mnemonic,school_latitude,school_longitude from tbl_school");
		 }
		
		 $i=0;

		
        	while( $school_address=mysql_fetch_assoc($school))
			{ 
			  $lat1=$_GET['latitude'];
		      $lon1=$_GET['longitude'];
			  
				 $lat2[$i]=$school_address['school_latitude'];
				
				 $lon2[$i]=$school_address['school_longitude'];
			
			  $sc_id[$i]=$school_address['school_mnemonic'];
				
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
	            $sc_id[$i]=$school_address['school_mnemonic'];

		
				  $sth = $db->query("SELECT sc.school_mnemonic as sc_id, sc.school_name as name,school_address as address, school_latitude as lat ,school_longitude as lon, school_email as description FROM tbl_school sc join tbl_school_admin sc_admin on sc.school_mnemonic=sc_admin.school_id where sc.school_mnemonic='$sc_id[$i]'");
				
					 $locations[$j] = $sth->fetchAll();
				    
					$j++;
					}
				 $i++;
		}
		
		if(count($locations)>0)
		{
     echo json_encode( $locations);
		}
		
         
    } catch (Exception $e) {
        echo $e->getMessage();
    }