<?php
//$json = json_encode(array( "username2" => "vandanakacha@gmail.com", "userpass2" => "vandana", "userType2" => "student"));
$json = file_get_contents('php://input');
$obj = json_decode($json);
//print_r($json);
  error_reporting(0);

     $lat1 = $obj->{'lat'};
     $long1 = $obj->{'long'};
     $entity_type = $obj->{'entity_type'};    //school/sponsor
     $range = $obj->{'range'};               //range in int
     $range_type = $obj->{'range_type'};    //1-miles and 0-km
     $loc_type = $obj->{'loc_type'};        // custome/current
     $place_name = $obj->{'place_name'};


     //RETURN ($miles ? ($km * 0.621371192) : $km);
    /* soak in the passed variable or set our own */
    $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
    $format = 'json'; //xml is the default

          $city = getAddress($lat1,$long1);


 if(!empty($loc_type))
		{
            include 'conn.php';
            get_location_details($entity_type,$range,$lat1,$long1,$range_type,$loc_type,$place_name,$city,$obj->{'input_id'},$format);

        }else
			{

			    $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
                 display($postvalue,$posts,$format);


			}


  function get_location_details($entity_type,$range,$lat1,$long1,$range_type,$loc_type,$place_name,$city,$input,$format)
  {

            /* create one master array of the records */
  			$posts = array();
            if($entity_type=='SCHOOL')
            {
              if($loc_type=='CURRENT')
              {
                $limit=10;
                $sql="select * from tbl_school where school_latitude!='' and school_longitude!='' limit $limit offset $input";
 			    $arr = mysql_query($sql);
      		   //	if(mysql_num_rows($arr)>=1)
                // {
        			while($test = mysql_fetch_assoc($arr))
                     {

        				 $lat2=$test['school_latitude'];
        				 $lon2=$test['school_longitude'];
                          $distance=calculate_distance($lat1,$long1,$lat2,$lon2,$range_type);
                           $kilometers = $distance * 1.609344;
        			    	if($kilometers<=$range)
        				    {
                               $posts[] = $test;

              				 //$posts[] = array('post'=>$test,"km"=>$distance,"doc_image"=>$doctor_image);


                            }
                         }

                                $postvalue['responseStatus']=200;
                				$postvalue['responseMessage']="Ok";
                				$postvalue['posts']=$posts;
                               //display($postvalue,$posts,$format);
							   header('Content-Type: application/json');
    					 echo json_encode($postvalue);
                    //}
               }
              else if($loc_type=='CUSTOM')
              {
                     $posts = array();
                    $address = str_replace(" ", "+", $place_name);
                    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
                    $json = json_decode($json);
                    $lat11 = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                    $long11 = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                     $limit=10;
                    $sql="select * from tbl_school where school_latitude!='' and school_longitude!='' limit $limit offset $input";

 			        $arr = mysql_query($sql);
                    if(mysql_num_rows($arr)>=1)
                    {
        		    	while($test = mysql_fetch_assoc($arr))
                        {


        				    $lat2=$test['school_latitude'];

        				    $lon2=$test['school_longitude'];
                            $distance=calculate_distance($lat11,$long11,$lat2,$lon2,$range_type);
                             $kilometers = $distance * 1.609344;
        			    	if($kilometers<=$range)
        				    {
                                 $posts[] = $test;

              				 //$posts[] = array('post'=>$test,"km"=>$distance,"doc_image"=>$doctor_image);


                            }

                         }
                                 $postvalue['responseStatus']=200;
                				$postvalue['responseMessage']="OK";
                				$postvalue['posts']=$posts;
                                //display($postvalue,$posts,$format);
								header('Content-Type: application/json');
								echo json_encode($postvalue);
                    }

                }else
                {

                    $postvalue['responseStatus']=204;
    				$postvalue['responseMessage']="Invalid Loc type";
    				$postvalue['posts']=null;
                    display($postvalue,$posts,$format);
                 }

        }
        else if($entity_type=='SPONSOR')
        {
               $limit=30;
            /* create one master array of the records */


              if($loc_type=='CURRENT')
              {

                             //$distance = calculate_distance($lat11,$long11,$lat2,$lon2,$range_type);
                             $radius = $range/ 6371.01; //6371.01 is the earth radius in KM
                             $minLat = $lat1 - $radius;
                             $maxLat = $lat1 + $radius;
                             $deltaLon = asin(sin($radius) / cos($lat1));
                             $minLon = $long1 - $deltaLon;
                             $maxLon = $long1 + $deltaLon;
                            $sql1 = "select id,sp_name,sp_address,sp_city,sp_country,sp_email,sp_phone,lat,lon,v_category,sp_img_path,v_status
                                     from tbl_sponsorer
                                     Where (lat Between $minLat And $maxLat
                                     And lon Between $minLon And $maxLon) limit $limit offset $input";
                            $arr1 = mysql_query($sql1);
      			//if(mysql_num_rows($arr)>=1)
                 //{
        			while($test1 = mysql_fetch_assoc($arr1))
                     {

                            $sp_name=$test1['sp_name'];
				            $sp_address=$test1['sp_address'];
        					$sp_city=$test1['sp_city'];
        					$sp_country=$test1['sp_country'];
        					$sp_email=$test1['sp_email'];
        					$sp_phone=$test1['sp_phone'];
        					$v_category=$test1['v_category'];
                            $sp_id=$test1['id'];
                  			$lat2=$test1['lat'];
                            $lon2=$test1['lon'];
                            $distance = calculate_distance($minLat,$minLon,$lat2,$lon2,$range_type);
                            $kilometers = $distance * 1.609344;
                            $distance1=round($kilometers,1);
            				   	$posts[]= array(
            						'id'=>$sp_id,
            						'sp_name'=>$sp_name,
            						'sp_address'=>$sp_address,
            						'sp_city'=>$sp_city,
            						'sp_country'=>$sp_country,
            						'sp_email'=>$sp_email,
            						'sp_phone'=>$sp_phone,
            						'lat'=>$lat2,
            						'lon'=>$lon2,
                                    'distance'=>$distance1,
            						'category'=>$v_category,
            						'sp_img_path'=>imageurl($test['sp_img_path'],'sclogo','sp_profile'),
                                     'count'=>mysql_num_rows($arr1)
            					);





                         }

                                $postvalue['responseStatus']=200;
                				$postvalue['responseMessage']="Ok";
                				$postvalue['posts']=$posts;
                                //$postvalue['Count']=$count1;

                                //display($postvalue,$posts,$format);
								header('Content-Type: application/json');
    					 echo json_encode($postvalue);
                    //}
               }

            else if($loc_type=='CUSTOM')
            {
                    $limit=50;
                    $posts = array();

                    $address = str_replace(" ", "+", $place_name);
                    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
                    $json = json_decode($json);
                    $lat11 = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                    $long11 = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};


                            $radius = $range/ 6371.01; //6371.01 is the earth radius in KM
                             $minLat = $lat11 - $radius;
                             $maxLat = $lat11 + $radius;
                             $deltaLon = asin(sin($radius) / cos($lat11));
                             $minLon = $long11 - $deltaLon;
                             $maxLon = $long11 + $deltaLon;
                            $sql1 = "select id,sp_name,sp_address,sp_city,sp_country,sp_email,sp_phone,lat,lon,v_category,sp_img_path,v_status
                                     from tbl_sponsorer
                                     Where (lat Between $minLat And $maxLat
                                     And lon Between $minLon And $maxLon) limit $limit offset $input";
                            $arr1 = mysql_query($sql1);

        			while($test1 = mysql_fetch_assoc($arr1))
                     {

                            $sp_name=$test1['sp_name'];
				            $sp_address=$test1['sp_address'];
        					$sp_city=$test1['sp_city'];
        					$sp_country=$test1['sp_country'];
        					$sp_email=$test1['sp_email'];
        					$sp_phone=$test1['sp_phone'];
        					$v_category=$test1['v_category'];
                            $sp_id=$test1['id'];
                  			$lat2=$test1['lat'];
                            $lon2=$test1['lon'];
                            $distance = calculate_distance($minLat,$minLon,$lat2,$lon2,$range_type);
                            $kilometers = $distance * 1.609344;
                            $distance1=round($kilometers,1);
            				   	$posts[]= array(
            						'post'=>array('id'=>$sp_id,
            						'sp_name'=>$sp_name,
            						'sp_address'=>$sp_address,
            						'sp_city'=>$sp_city,
            						'sp_country'=>$sp_country,
            						'sp_email'=>$sp_email,
            						'sp_phone'=>$sp_phone,
            						'lat'=>$lat2,
            						'lon'=>$lon2,
                                    'distance'=>$distance1,
            						'category'=>$v_category,
            						'sp_img_path'=>imageurl($test['sp_img_path'],'sclogo','sp_profile'),
                                     'count'=>mysql_num_rows($arr1)
            					));





                         }

                                $postvalue['responseStatus']=200;
                				$postvalue['responseMessage']="Ok";
                				$postvalue['posts']=$posts;
                                //$postvalue['Count']=$count1;

                                display($postvalue,$posts,$format);


             }else
                {

                    $postvalue['responseStatus']=204;
    				$postvalue['responseMessage']="Invalid Loc type";
    				$postvalue['posts']=null;
                     display($postvalue,$posts,$format);
                 }
          }



   }
      function calculate_distance($lat1,$long1,$lat2,$lon2,$range_type)
      {



        				    /*$pi80 = M_PI / 180;
        					$lat1 *= $pi80;
        					$long1 *= $pi80;
        					$lat2*= $pi80;
        					$lon2*= $pi80;

        					$r = 6372.797; // mean radius of Earth in km
        					$dlat = $lat2 - $lat1;
        					$dlng = $lon2- $long1;
        					$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng/ 2) * sin($dlng / 2);
        					$c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        		                $km= $r * $c;
                               // $distance= $km;
                                $distance= $range_type ? ($km * 0.621371192) : $km;
                                return $distance;   */


                              $theta = $long1 - $lon2;

                              $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));

                              $miles = acos($miles);

                              $miles = rad2deg($miles);

                              $miles = $miles * 60 * 1.1515;

                              return $miles;


      }

      function imageurl($value,$type='',$img='')
      {
			//$logoUrl=@get_headers(base_url('/Assets/images/sp/profile/'.$value));
			if($img=='sp_profile'){
				$path='sp/profile/';
			}elseif($img=='product'){
				$path='sp/productimage/';
			}elseif($img=='spqr'){
				$path='sp/coupon_qr/';
			}else{
				$path='';
			}
			$base_url=$_SERVER['HTTP_HOST'];
			$logoUrl=@get_headers($base_url.'/Assets/images/'.$path.$value);
			$tlogoUrl=@get_headers('http://tsmartcookies.bpsi.us/'.$value);
			$slogoUrl=@get_headers('http://www.smartcookie.in/'.$value);
			if($logoUrl[0] == 'HTTP/1.1 200 OK' && $value!='new-product.jpg' && $value!='' ){
				$logoexist=$base_url.'/Assets/images/'.$path.$value;
			}elseif($tlogoUrl[0] == 'HTTP/1.1 200 OK' && $value!=''){
				$logoexist='http://tsmartcookies.bpsi.us/core/'.$value;
			}elseif($slogoUrl[0] == 'HTTP/1.1 200 OK' && $value!=''){
				$logoexist='http://www.smartcookie.in/core/'.$value;
			}else{
				if($type=='sclogo'){
					$logoexist=$base_url.'/Assets/images/sp/profile/newlogo.png';
				}elseif($type=='avatar'){
					$logoexist=$base_url.'/Assets/images/avatar/avatar_2x.png';
				}else{
					$logoexist=$base_url.'/Assets/images/sp/profile/imgnotavl.png';
				}
			}
			return $logoexist;
		}
        function display($postvalue,$posts,$format)
        {

              	if($format == 'json') {
    					header('Content-Type: application/json');
    					 echo json_encode($postvalue);
  					}
 				 else {
   				 		header('Content-type: text/xml');
    					echo '';
   					 	foreach($posts as $index => $post) {
     						 if(is_array($post)) {
       							 foreach($post as $key => $value) {
        							  echo '<',$key,'>';
          								if(is_array($value)) {
            								foreach($value as $tag => $val) {
              								echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            											}
         									}
         							  echo '</',$key,'>';
        						}
      						}
    				}
   			 echo '';
 				 }


        }
        function getAddress($latitude,$longitude)
        {

                 $geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=false');

                    $output= json_decode($geocode);

                for($j=0;$j<count($output->results[0]->address_components);$j++){
                           $cn=array($output->results[0]->address_components[$j]->types[0]);
                       if(in_array("locality", $cn))
                       {
                        $city= $output->results[0]->address_components[$j]->long_name;
                       }
                        }
                       return $city;

              }

                    @mysql_close($con);

?>