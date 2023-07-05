
<?php
$report="";

include("conn.php");
$user_type=$_GET['user_type'];
$id=$_SESSION['id'];
if($user_type=="School_admin")
{

 $arr=mysql_query("select t.name,t.school_id, sp.sc_point,sp.point_date from tbl_teacher_point sp join tbl_school_admin t where sp.assigner_id=t.id and sp.`sc_entities_id`='102' and sp.sc_teacher_id='$id' order by sp.id desc");    
 }
 else
 {


 
 
 }      


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<script>
$(document).ready(function() {
$('#example').DataTable();
} );
</script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>







</head>
<body>
<div class="container" style="padding:10px;">
 <div class="row"  align="center" >
       
        <div id="log" >
    
     
        	
        		
        		<?php
				
				 $i=0;
				if($user_type=='School_admin')
				{
				?>
                    <table id="example" class="col-md-10 table-bordered table-striped table-condensed cf" align="center" style="width:100%">
                		<thead class="cf">
           	<tr style="background-color:#6666CC; color:#FFFFFF; height:30px;">
                	<th>Sr. No.</th>
                    <th>School Admin Name</th>
                     <th>School Name</th>
                    <th>Points</th>
               
                    <th>Point Date</th>
                   
                </tr>
               </thead>
                	
		<?php		while($row = mysql_fetch_array($arr))
				{
				$i++;?>
				
                <tr>
                <td ><?php echo $i;?></td>
                   
                    <td ><?php echo $row['name'];?></td>
                    <td ><?php  $school_id=$row['school_id'];
					$sql=mysql_query("select school_name from tbl_school where id='$school_id'");
					$result=mysql_fetch_array($sql);
					echo $result['school_name'];
					
					
					 ?></td>
                 
                    <td ><?php echo $row['sc_point'];?></td>
                 
                     <td ><?php echo $row['point_date'];?></td>
                </tr>
           
                <?php
				}?>
				     </table>
				
				<?php }
				else
				{
				?>
                    <table id="example1" class="col-md-10 table-bordered table-striped table-condensed cf" align="center" style="width:100%">
                	<thead  class="cf" >
        			<tr style="background-color:#6666CC; color:#FFFFFF; height:30px;">
        				 	<th>Sr. No.</th>
                    <th>Student Name</th>
                     <th>School Name</th>
                    <th>Points</th>
               
                    <th>Point Date</th>
        			</tr>
        		</thead>
                	<?php		while($row = mysql_fetch_array($arr))
				{
				$i++;?>
				
                 <tr>
                   <td ><?php echo $i;?></td>
                   <td ><?php echo $row['std_name'];?></td>
                    <td ><?php $school_id= $row['school_id'];
					$sql=mysql_query("select school_name from tbl_school where id='$school_id'");
					$result=mysql_fetch_array($sql);
					echo $result['school_name'];
					
					
					 ?></td>
                 
                    <td ><?php echo $row['sc_point'];?></td>
                 
                     <td ><?php echo $row['point_date'];?></td>
                	
                </tr>
                <?php
				
				}
				?>
                </table>
				<?php }
				?>
        		
        	
				
        </div>
    </div>
    </div>

    
</body>
</html>
