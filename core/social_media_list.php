<?php
include('conn.php');
$i=1;

$sql=mysql_query("SELECT * FROM tbl_social_points order by id ");

while($result=mysql_fetch_array($sql)){

?>
<tr>
<td data-title="Sr.No."><?php echo $i;   ?></td>
<td data-title="Media Name"><?php echo  $result['media_name'];?></td>
<td data-title="Media Logo">  <center> <img src="<?php echo $result['media_logo'];?>"   style="border:1px solid #CCCCCC;height:30px;" class="img-responsive" alt="Image Not Available"/></center></td>
<td data-title="Points"><?php echo $result['points'];?></td>


<td data-title="Edit" width="10%"  ><button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo  $result['media_name'].','. $result['id'] .','.$result['points'];?>"><span class="glyphicon glyphicon-pencil"></span></button><a style="text-decoration:none"></td>
<td data-title="Delete" width="10%" ><button type="button" class="btn btn-default" onclick="delete_social_media(<?php echo $result['id'];?>)"><span class="glyphicon glyphicon-trash"></span></button></td>


</tr>
<?php  $i++; }?>
