<?php
include('conn.php');
$points=$_POST['points'];
$media_name=$_POST['media_name'];
$query=mysql_query("select * from tbl_social_points where media_name like '$media_name'");
$count=mysql_num_rows($query);
if($count==0)
{



if($_FILES['filUpload']['name']!="")
				 {
				   $img= $_FILES['filUpload']['name'];
				$ex_img = explode(".",$img);
				
				//date format changes by sachin 03-10-2018
				// $img_name = $ex_img[0]."_".date('mdY').".".$ex_img[1];
				   $img_name = $ex_img[0]."_".date('Ymd').".".$ex_img[1];
				//End date format changes by sachin 03-10-2018                   

				 	$filenm='Images/'.$img_name;

				$sql=mysql_query("insert into tbl_social_points (media_name,media_logo,points)values('$media_name','$filenm','$points')");



	    	move_uploaded_file($_FILES['filUpload']['tmp_name'],$filenm);
				echo "media_name successfully added";


			}

			else
			{
        //$nik = $_FILES['filUpload']['name'];
			echo "Please upload image";

			}

}
else
{
  echo "media_name is already exists";
}
?>
