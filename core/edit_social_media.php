<?php
include('conn.php');
$points=$_POST['points'];
$media_name=$_POST['edit_media_name'];
$id=$_POST['id'];

if($_FILES['filUpload']['name']!="")
				 {
				$img= $_FILES['filUpload']['name'];
				$ex_img = explode(".",$img);
        $img_name = $ex_img[0]."_".date('mdY').".".$ex_img[1];
				$filenm='Images/'.$img_name;
				$sql=mysql_query("update tbl_social_points set media_name = '$media_name',media_logo='$filenm',points='$points' where id='$id'");
	    	move_uploaded_file($_FILES['filUpload']['tmp_name'],$filenm);
				echo "successfully updated";
			}

			else
			{
      $sql=mysql_query("update tbl_social_points set media_name='$media_name',points='$points' where id='$id'");
				echo "successfully updated";

			}



?>
