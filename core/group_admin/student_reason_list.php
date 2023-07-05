<?php

include('conn.php');
 $sql="select * from tbl_student_recognition";
$i=0;
   $arr1 = mysql_query($sql);
   while($row1 = mysql_fetch_array($arr1))
   {
   $i++;
   ?>
   <tr>
       <td data-title="Sr.No" width="10%" ><?php echo $i;?></td>
       <td data-title="Activity" width="30%"  ><?php echo ucwords($row1['student_recognition']);?></td>

       <td data-title="Edit" width="10%"  ><button type="button" class="btn btn-default"  data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $row1['student_recognition'] .','. $row1['id'] ;?>"><span class="glyphicon glyphicon-pencil"></span></button><a style="text-decoration:none"></td>
       <td data-title="Delete" width="10%" ><button type="button" class="btn btn-default"  onclick="delete_reason(<?php echo $row1['id'];?>)"><span class="glyphicon glyphicon-trash"></span></button></td>


   </tr>
   <?php
   }
   ?>
