<?php 
//added condition for sbuject and project for SMC-4838 om 21/09/2020
//$this->load->view('stud_header',$studentinfo);
$school_type = $teacher_info[0]->sctype;
$t_id = $this->session->userdata('t_id');
$school_id = $this->session->userdata('school_id');//echo $t_id;
?>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="container-fluid">
		<div class="row clearfix">
			<div class="block-header" align="center">
				  <h2>My <?php echo ($school_type=='organization')?'Projects':'Subjects'; ?></h2>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll" align="center">
				    <div class="name">
                        <form action="<?php echo base_url().'Teachers/aa';?>" method="post">
                            <?php $yr=$this->session->userdata('acadmic_yr'); 
                           ?>
                        <select id="year" name="year">Year
                            <?php foreach($student_subjectlist_Ayear as $row)
                            {?>
                               <option value="<?php echo $row['Academic_Year']; ?>" <?php if($row['Academic_Year']==$yr){?> selected="selected" <?php }?>><?php echo $row['Academic_Year']; ?></option>
                           <?php } ?>
                        </select>
                        <input type="submit" name="year1" value="Submit">
                       </form>
                      
                    </div> 
			</div>
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-inverse table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
                    <thead>
						<tr>
							<th>Sr. No.</th>
							<th><?php echo ($this->session->userdata('usertype')=='teacher')?'Subject':'Project'; ?></a> Name</th>
							<th><?php echo ($this->session->userdata('usertype')=='teacher')?'Subject':'Project'; ?> Code</th>
							<th>Department Name</th>
							<th><?php echo ($this->session->userdata('usertype')=='teacher')?'Course':'Employee'; ?> Level</th>
							<th><?php echo ($this->session->userdata('usertype')=='teacher')?'Semester':'Default Duration'; ?> </th>
							<th><?php echo ($this->session->userdata('usertype')=='teacher')?'Academic':'Financial'; ?> Year</th>
							<th>Div Id</th>
							  <th style="width:100px;">
                                    <center>Delete</center>
                                </th>
						</tr>
                    </thead>
                    <tbody>
					<?php

					// print_r($teacherSubject_list);die;
						$i=1;
						
						foreach($teacherSubject_list1 as $teacherSubject){
						
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<!-- <a href="<?php echo base_url().'Teachers/teacher_subject_student?sub_id='?><?php echo $teacherSubject['subjcet_code']; ?>"><?php echo $teacherSubject['subjectName']; ?></a> -->
							
							<td><a onclick="confirmSMS( '<?php echo $teacherSubject['subjcet_code']; ?>','<?php echo $teacherSubject['Department_id']; ?>','<?php echo $teacherSubject['CourseLevel']; ?>','<?php echo $teacherSubject['Semester_id']; ?>','<?php echo $teacherSubject['AcademicYear']; ?>','<?php echo $teacherSubject['Division_id']; ?>','<?php echo $teacherSubject['subjectName']; ?>','<?php echo $teacherSubject['Branches_id']; ?>');"><?php echo $teacherSubject['subjectName']; ?></a></td>
							<td><?php echo $teacherSubject['subjcet_code']; ?></td>
							<td><?php echo $teacherSubject['Department_id']; ?></td>
							<td><?php echo $teacherSubject['CourseLevel']; ?></td>
							<td><?php echo $teacherSubject['Semester_id']; ?></td>
							<td><?php echo $teacherSubject['AcademicYear']; ?></td>
							<td><?php echo $teacherSubject['Division_id']; ?></td>

							 <td style="width:100px;">
							 	
							 	
							 	<center><a href="<?php echo base_url('teachers/delete_row/'.$teacherSubject['subjcet_code']."/".$t_id."/".urldecode($teacherSubject['Department_id'])."/".$school_id."/".urldecode($teacherSubject['Semester_id'])."/".$teacherSubject['Division_id']."/".$teacherSubject['CourseLevel']."/".$teacherSubject['AcademicYear']);?>" onclick="return confirmation()" class="delete glyphicon glyphicon-trash"></a>
                                            </center>

                                        </td>
						</tr>
							<?php } ?>
						
					</tbody>
				</table>
			</div>
			 
		</div>
	</div>
</div>
<head>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
		<script>
			document.getElementById("otheract").className += " active";
			document.getElementById("mysub").className += " active";
		</script>
</head>

<script type="text/javascript">
	function confirmSMS(subjcet_code,Department_id,CourseLevel,Semester_id,AcademicYear,Division_id,subjectName,Branches_id) 
	{
		//alert(Division_id);
                var answer = confirm("Are you sure,want to see student list.");
                if (answer)
                    {
                    	 window.location="./teacher_subject_student_var?subjcet_code="+subjcet_code+"&Department_id="+Department_id+"&CourseLevel="+CourseLevel+"&Semester_id="+Semester_id+"&AcademicYear="+AcademicYear+"&Division_id="+Division_id+"&subjectName="+subjectName+"&Branches_id="+Branches_id;
                    
                    }
           
    }
    function confirmation() {
//alert(xxx);
        var answer = confirm("Are you sure you want to delete?")
        if (answer) {
                   //alert('Record Deleted Successfully'); 
                   return true;
            
        }
        else{
        	return false;
        }
        
    }
</script>