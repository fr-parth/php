<?php
include_once("hr_header.php");?>


<div class="panel panel-default"><br>
  <!-- Default panel contents -->
  <div class="panel-heading" align="center"><b>Employee Project Report</b></div><br>

  <!-- Table -->
  
 <p><table border="1" align="center" width="450" height="300">
  <tr>
    <td align="center"><b>Report Name</b></td>
    <td align="center"><b>No of Count</b></td>
  </tr>
  <tr>
    <td align="center">Duplicate Reocrd</td>
     <?php $Duplicate=mysql_query("select * from  tbl_student_subject where status='duplicate'");
		            $Duplicatecount=mysql_num_rows($Duplicate);
					$row=mysql_fetch_array($Duplicate);
					$duplicate1=$row['status'];
		 ?>
      <?php
             if($duplicate1=="duplicate")
			 {
		 ?>
    <td align="center"><a href="showreportstudent.php?error=<?=$duplicate1?>"><?=$Duplicatecount?></a></td>
    <?php
           } 
		   else
		    {
			?> <td align="center"><?=$Duplicatecount?></a></td>
    <?php 
	 }
	?>
  </tr>
   </tr>
        <td align="center">Employee Not Match</td>
        <?php $teacher=mysql_query("select * from tbl_student_subject where status='Teacher_id Not Match'");
		            $techercount=mysql_num_rows($teacher);
					$row1=mysql_fetch_array($teacher);
					 $teacher1=$row1['status'];
		 ?>
      <?php
             if($teacher1=="Teacher_id Not Match")
			 {
		 ?>
    <td align="center"><a href="showreportstudent.php?error=<?=$teacher1?>"><?=$techercount?></a></td>
    <?php
           } 
		   else
		    {
			?> <td align="center"><?=$techercount?></a></td>
    <?php 
	 }
	?>
      </tr>
  <tr>
    <td align="center">Project Not Match</td>
    <?php $subject=mysql_query("select * from tbl_student_subject where status='Subject Code'");
		            $subjecttecount=mysql_num_rows($subject);
					$row2=mysql_fetch_array($subject);
				$subject2=$row2['status'];
					
		 ?>
    <?php
             if($subject2=="Subject Code")
			 {
		 ?>
    <td align="center"><a href="showreportstudent.php?error=<?=$subject2?>"><?=$subjecttecount?></a></td>
    <?php
           } 
		   else
		    {
			?> <td align="center"><?=$subjecttecount?></a></td>
    <?php 
	 }
	?>
  </tr>
  <tr>
   <!-- <td align="center">Update Record</td>
     <?php //$updated=mysql_query("select status from tbl_student_subject where status='duplicate'");
		           // $updatedcount=mysql_num_rows($updated);
					 
					
		 ?>
    <td align="center"><a href="showreport.php?id=<>"><?//=$updatedcount?></a></td>
  </tr>-->
</table>

<!-- <table border="1">
                     <tr ><th><b>Teacher Not Match</b></th><th>Subject Not Match</th><th>Duplicate Record</th><th>Updated Record</th>
                        </thead><tbody>
                 
                    <tr>
                    <td data-title="Sr.No" ><b>22</b></td>
					<td data-title="Teacher ID" ><b>222</b></td>
                    <td data-title="Name" >333</td> 
                   
                   
                   </td>
                   </tr>
                   </thead>
                   <tbody>
                   
</table>-->
</div>
<?php
include"footer.php";
?>