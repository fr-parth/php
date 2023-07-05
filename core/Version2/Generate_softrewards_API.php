<?php

 $json = file_get_contents('php://input');
$obj = json_decode($json);
    error_reporting(0);
    $reward_name = $obj->{'reward_name'};
    $points = $obj->{'points'};
    $User_Type = $obj->{'user_type'};
    $img = $obj->{'User_Image'};
    $target_dir = "softrewardImages/";

  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json';

include 'conn.php';





    if(!empty($User_Type) && !empty($img) && !empty($reward_name) && $points!='')
	{
		$query=mysql_query("SELECT * FROM `softreward` WHERE `user`='$User_Type' and rewardType='$reward_name'");
          	if(mysql_num_rows($query)==0)
	    	{

				 $imageDataEncoded=$obj->{'User_Imagebase64'};
				  $ex_img = explode(".",$img);
				  $img_name = $ex_img[0]."_".$p_id."_".date('mdY');
				  $full_name_path = $target_dir.$img_name.".".$ex_img[1];
				  $imageName = "../".$full_name_path;
				  $imageData = base64_decode($imageDataEncoded);
				  $source = imagecreatefromstring($imageData);
				   $imageSave = imagejpeg($source,$imageName,100);
				$insertsoftreward=mysql_query("INSERT INTO softreward (`user`,`rewardType`,`fromRange`,`imagepath`) VALUES ('$User_Type','$reward_name',
                                                '$points','$full_name_path')");

						if(!$insertsoftreward)
						   {
	                               mysql_error($insertsoftreward) or die($insertsoftreward);
	                       }
						   else
						   {
						             $postvalue['responseStatus']=200;
                			    	 $postvalue['responseMessage']=$reward_name." "."for the"." ".$User_Type." "."is successfully saved.";
                				     $postvalue['posts']=null;
                                     header('Content-type: application/json');
                   				     echo json_encode($postvalue);
						   }



	        }
            else
            {

                $postvalue['responseStatus']=204;
				$postvalue['responseMessage']=$reward_name." "."for the"." ".$User_Type." "."is already exist.";
				$postvalue['posts']=null;
                 header('Content-type: application/json');
   				 echo json_encode($postvalue);
            }

			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$posts;

		}


	else
			{

			   $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;

			  header('Content-type: application/json');
   			  echo  json_encode($postvalue);


			}


  @mysql_close($con);

?>