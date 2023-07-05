 <?php


include('scadmin_header.php');?>

<?php
$report="";

/*$id=$_SESSION['id']; */
           $fields=array("id"=>$id);
		  /* $table="tbl_school_admin";  */
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];

?>

<html>
<head>


<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"></link>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
	   $('#example').DataTable();
	/* $('#example tbody tr').click(function(){
        window.location = $(this).data('href');   
    });*/
} );
</script>
<style>

#example tbody tr{
cursor : pointer;

}
</style>
</head>
<body>
<div class="container">

<form method="post" >
<table align="center" style="margin-top: 1cm;">
<tr>
<td>
<dic class='row'>
<div class='col-lg-12'>
<div class="form-group has-success">
<input  class="form-control"  type="text" name="name" placeholder="<?php echo $dynamic_teacher." "."Name"?>" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; }?>">
</div>
</div>
</td>
<td>
<div class='col-lg-12'>
<div class="form-group has-success">
<input  class="form-control"  type="text" name="tid" placeholder="<?php echo $dynamic_teacher." "."ID"?>" value="<?php if(isset($_POST['tid'])) { echo $_POST['tid']; }?>">
</div>
</div>
</td>
<td>
<div class='col-lg-12'>
<div class="form-group has-success">
<!-- Camel casing done for Go by Pranali -->
<input  class="form-control"  type="submit" value="Go" name="submit">
</div>
</div>
</td>
</tr>
</table>
</form>
</div>

</body>
</html>




<?php
if(isset($_POST['submit']))
{
$name = trim($_POST['name']);
$tid = trim($_POST['tid']);



$query="SELECT school_id,id,t_id, t_complete_name, tc_balance_point, tc_used_point FROM tbl_teacher";
$query1=" where ";

if($name=='' & $tid=='')
	{
		echo "<script>window.alert('please enter a field')</script>";
		echo "<script>window.location.assign('search_teacher_points.php')</script>";
	}
else
{
	$f = 0;
	if($name!='')
		{
			$query1.="t_complete_name like '%$name%'";
			$f = 1;
		}
	if($tid!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="t_id = '$tid'";
			$f=1;
		}
	
	
	
	$query_final=$query.$query1." and  school_id ='$sc_id'";
	//echo $query_final;  exit;
	$sql = mysql_query($query_final);
	


	if(mysql_num_rows($sql)>0)
		{
			
	?>
	
			<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
			<tr style="background-color:#909497;color: white;">
			<th style="text-align:center">Sr.No</th>
			<th style="text-align:center"><?php echo $dynamic_teacher;?> Name</th>
			<th style="text-align:center"><?php echo $dynamic_teacher;?> Id</th>
			<th style="text-align:center">Balance Green Points</th>
			<th style="text-align:center">Used Green Points</th>
			<th style="text-align:center">Assign</th>
			</tr>
			</thead>
			<tbody>
			
	<?php
			 $c = 1;
			while($rows = mysql_fetch_array($sql))
				{
				$teacher_id=$rows['t_id'];
				?>
       		
            <tr>
            <td style="padding:10px;" align="center"><?php echo $c;?></td>
            <td style="padding:10px;" align="center"><?php echo $rows['t_complete_name'];?></td>
              <td style="padding:10px;" align="center"><?php echo $rows['t_id'];?></td>
                <td style="padding:10px;" align="center"><?php echo $rows['tc_balance_point'];?></td>
                  <td style="padding:10px;" align="center">  <?php $query=mysql_query("select sum(sc_point) as sc_point  from tbl_student_point where sc_entites_id ='103' and sc_teacher_id='$teacher_id'");

					 $test=mysql_fetch_array($query);

					 

								  $sc_point=$test['sc_point'];

								  if($sc_point==""|| $sc_point==0)

								  {

								  echo "0";

								  }

								  else

								  {

								  echo $sc_point;

								  }

								 ?>

</td>      
                <td>
                                <a href='teacher_assignpoint_search.php?id=<?php echo $rows["t_id"].",".$rows["school_id"];?>'> <input type="button" value="Assign" name="assign"/></a>
                        </td>
            </tr>
            
     <?php $c++; }?>
        </tbody>
    </table>
	<?php }
			
			
			
			
			
			
			
			
			
			
			
	
	else
		{
			echo "<script>window.alert('No records found')</script>";
			//echo "<script>window.location.assign('search_teacher_points.php')</script>";*/
		}
		
}
}


?>
<?php

?>
