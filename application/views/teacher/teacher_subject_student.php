<?php 
//added condition for sbuject and project for SMC-4838 om 21/09/2020
//$school_type = $teacher_info[0]->sctype;?>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="block-header" align="center">
                  <h2>My Students &nbsp;&nbsp;&nbsp; Division :<?php echo $this->session->userdata('Division_id1'); ?> &nbsp;&nbsp;&nbsp;Subject :<?php echo $this->session->userdata('subjectName1'); ?>
 </h2>
            </div>
        <?php 
         //print_r($row);
        //print_r($student_info1);?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                    <table id="example" class="table table-striped table-inverse table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th><?php echo ($this->session->userdata('usertype')=='teacher')?'Student':'Project'; ?></a> Id</th>
                            <th><?php echo ($this->session->userdata('usertype')=='teacher')?'Student':'Project'; ?> Name</th>
                            <th>School Name</th>
                            <th>Student Department</th>
                            <th>Student Class</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    <?php
                        $i=0;
                        foreach($student_info1 as $teacherstud){
                    ?>  
                        <tr>
                            <td><?php echo $i+1; ?></td>
                            <td><?php echo $teacherstud['student_id']; ?></td>
                            <td><?php echo $teacherstud['std_complete_name']; ?></td>
                            <td><?php echo $teacherstud['std_school_name']; ?></td>
                            <td><?php echo $teacherstud['std_dept']; ?></td>
                            <td><?php echo $teacherstud['std_class']; ?></td>
                            
                        </tr>
                            <?php $i++; } ?>
                        
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