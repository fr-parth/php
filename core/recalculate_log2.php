<?php
 include("scadmin_header.php");

	$query = mysql_query("select * from tbl_school_admin where id = ".$_SESSION['id']);
	$value = mysql_fetch_array($query);
	$school_id=$value['school_id'];
	$id=$_SESSION['id'];
    $stud_id=$_GET['s_id'];
    $school_id1=$_GET['sc_id'];

?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap 101 Template</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>

    <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>

        <script src="js/city_state.js" type="text/javascript"></script>

    </head>
    <body>



<div class="container" style="margin-top:20px;" >
    <div><h1>All Points Activity Log</h1></div>
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#tab_a" data-toggle="tab">Green Point By Admin</a></li>
  <li role="presentation"><a href="#tab_d" data-toggle="tab">Green Point By Teacher</a></li>
  <li role="presentation"><a href="#tab_b" data-toggle="tab">Blue Point Log</a></li>
  <li role="presentation"><a href="#tab_c" data-toggle="tab">Purple Point Log</a></li>
</ul>
<div class="tab-content newboxes" id="newboxes1" style="margin-top:10px;">
<div class="tab-pane active" id="tab_a" >

<div class="container">
<div class="row">

<div style="height:10px;"></div>



        <div style="height:20px;"></div>
        <div style="height:10px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        <h2 style="padding-left:20px; margin-top:2px;color:#666">Student Log</h2>
        </div>
        <div   class="container" style="padding-top:20px;">
        <table id="example" class=" table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        		<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th width="5%">Sr. No.</th>
                    <th width="15%">Student Name</th>
                    <th width="15%">Green Points</th>
                    <th width="15%">Reason</th>
                    <th width="15%">Assigned Date</th>
                    
                </tr>

        		</thead>

                <?php

                $i=1;

                $arrs = mysql_query("SELECT ts.`school_id`,ts.`std_complete_name`,tsp.`sc_point`,tsp.`sc_studentpointlist_id`,tsp.`reason`,tsp.`activity_type`,tsp.`point_date`,ts.`std_PRN`,ts.`std_school_name` FROM tbl_student ts LEFT JOIN tbl_student_point tsp ON ts.std_PRN=tsp.`sc_stud_id` AND ts.`school_id`=tsp.`school_id` WHERE sc_stud_id ='$stud_id' AND sc_entites_id =102 AND tsp.`school_id`='$school_id1' AND activity_type !='' group by std_complete_name order by std_complete_name");


				while($student = mysql_fetch_array($arrs))
                {
                     echo $student['std_complete_name'];

                ?>
                <tbody>


                <tr>


                   <td data-title="Sr. No." width="5%"> <?php echo $i;?></td>
				   
                   <td data-title="Student Name" width="15%"><?php echo $student['std_complete_name'];?></td>

                   <td data-title="Green points" width="15%"><?php echo $student['sc_point'];?></td>

                   <td data-title="Reason"   width="15%"><?php echo $student['reason'];?></td>

                   <td data-title="Assigned Date" width="15%"><center><?php echo $student['point_date'];?></center></td>


                </tr>
			    <?php
				$i++;
				}
                ?>
               </tbody>
        	   </table>



</div>
</div>
</div>

        </div>
		
		
		
		
		<div class="tab-pane newboxes" id="tab_b">

<div class="container">
<div class="row">

<div style="height:10px;"></div>



        <div style="height:20px;"></div>
        <div style="height:10px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        <h2 style="padding-left:20px; margin-top:2px;color:#666">Student Log</h2>
        </div>
        <div   class="container" style="padding-top:20px;">
        <table id="example" class=" table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        		<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th width="5%">Sr. No.</th>
                    <th width="15%">Student Name</th>
                    <th width="15%">Green Points</th>
                    <th width="15%">Reason</th>
                    <th width="15%">Assigned Date</th>
                    
                </tr>

        		</thead>

                <?php

                $i=1;

                $arrs = mysql_query("select tp.sc_point,t_list,point_date,sc_teacher_id,t.tc_used_point,t.t_complete_name from tbl_teacher_point tp join tbl_teacher t on tp.sc_teacher_id = t.t_id AND tp.school_id = '$school_id' join tbl_thanqyoupointslist on tbl_thanqyoupointslist.id=sc_thanqupointlist_id where t.school_id='$school_id' ORDER BY tp.id DESC LIMIT $offset, $rec_limit");


				while($teacher = mysql_fetch_array($arrs))
                {


                ?>
                <tbody>


                <tr>


                   <td data-title="Sr. No." width="5%"> <?php echo $i;?></td>
				   
                   <td data-title="Student Name" width="15%"><?php echo $teacher['t_complete_name'];?></td>

                   <td data-title="Green points" width="15%"><?php echo $teacher['green_point'];?></td>

                   <td data-title="Reason"   width="15%"><?php echo $teacher['t_list'];?></td>

                   <td data-title="Assigned Date" width="15%"><center><?php echo $teacher['point_date'];?></center></td>

                   
                </tr>
			    <?php
				$i++;
				}
                ?>
               </tbody>
        	   </table>



</div>
</div>
</div>


        </div>
		
		
		
		
		
		
        <div class="tab-pane active" id="tab_d" >

<div class="container">
<div class="row">

<div style="height:10px;"></div>



        <div style="height:20px;"></div>
        <div style="height:10px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        <h2 style="padding-left:20px; margin-top:2px;color:#666">Student Log</h2>
        </div>
        <div   class="container" style="padding-top:20px;">
        <table id="example" class=" table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        		<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th width="5%">Sr. No.</th>
                    <th width="15%">Student Name</th>
                    <th width="15%">Blue Points</th>
                    <th width="15%">Reason</th>
                    <th width="15%">Assigned Date</th>
                    
                </tr>

        		</thead>

                <?php

                $i=1;

                $arrs = mysql_query("SELECT ts.`school_id`,ts.`std_complete_name`,tsp.`sc_point`,tsp.`sc_studentpointlist_id`,tsp.`reason`,tsp.`activity_type`,tsp.`point_date`,ts.`std_PRN`,ts.`std_school_name` FROM tbl_student ts LEFT JOIN tbl_student_point tsp ON ts.std_PRN=tsp.`sc_stud_id` AND ts.`school_id`=tsp.`school_id` WHERE sc_stud_id ='$stud_id' AND sc_entites_id =103 AND tsp.`school_id`='$school_id1' AND activity_type !='' std_complete_name order by std_complete_name");


				while($student = mysql_fetch_array($arrs))
                {


                ?>
                <tbody>


                <tr>


                   <td data-title="Sr. No." width="5%"> <?php echo $i;?></td>
				   
                   <td data-title="Student Name" width="15%"><?php echo $student['std_complete_name'];?></td>

                   <td data-title="Blue points" width="15%"><?php echo $student['blue_point'];?></td>

                   <td data-title="Reason"   width="15%"><?php echo $student['reason'];?></td>

                   <td data-title="Assigned Date" width="15%"><center><?php echo $student['point_date'];?></center></td>


                </tr>
			    <?php
				$i++;
				}
                ?>
               </tbody>
        	   </table>



</div>
</div>
</div>

</div>
<div class="tab-pane newboxes" id="tab_b">

<div class="container">
<div class="row">

<div style="height:10px;"></div>



        <div style="height:20px;"></div>
        <div style="height:10px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        <h2 style="padding-left:20px; margin-top:2px;color:#666">Student Log</h2>
        </div>
        <div   class="container" style="padding-top:20px;">
        <table id="example" class=" table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        		<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th width="5%">Sr. No.</th>
                    <th width="15%">Student Name</th>
                    <th width="15%">Purple Points</th>
                    <th width="15%">Reason</th>
                    <th width="15%">Assigned Date</th>
                  
                </tr>

        		</thead>

                <?php

                $i=1;

                $arrs = mysql_query("select tp.sc_point,t_list,point_date,sc_teacher_id,t.tc_used_point,t.t_complete_name from tbl_teacher_point tp join tbl_teacher t on tp.sc_teacher_id = t.t_id AND tp.school_id = '$school_id' join tbl_thanqyoupointslist on tbl_thanqyoupointslist.id=sc_thanqupointlist_id where t.school_id='$school_id' ORDER BY tp.id DESC LIMIT $offset, $rec_limit");


				while($teacher = mysql_fetch_array($arrs))
                {


                ?>
                <tbody>


                <tr>


                   <td data-title="Sr. No." width="5%"> <?php echo $i;?></td>
				   
                   <td data-title="Student Name" width="15%"><?php echo $teacher['t_complete_name'];?></td>

                   <td data-title="Purple points" width="15%"><?php echo $teacher['purple_point'];?></td>

                   <td data-title="Reason"   width="15%"><?php echo $teacher['t_list'];?></td>

                   <td data-title="Assigned Date" width="15%"><center><?php echo $teacher['point_date'];?></center></td>

                   
                </tr>
			    <?php
				$i++;
				}
                ?>
               </tbody>
        	   </table>



</div>
</div>
</div>


        </div>
       


</div>

</div><!-- end of container -->
</body>
</html>