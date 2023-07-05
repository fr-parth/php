
<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head><title>User Profile</title>
    
  
</head>
<style>
.mandatory{color:red;}
</style>
<script>
    function remove(){
        var r = confirm("Remove profile ");
            if (r == true) {
                    window.location.href ="<?php echo base_url('main/remove_profile_image')?>";
                }
        }
</script>
<script>
function student_pass_info()
{
    var phone = $('#phone').val();
     if(!$.trim(mobileNumber))
    {
        alert("Please enter user's mobile number!!");
        $("#phone").focus();
        $("#phone").val("");
        return false;
    }
    else if(numeric.test(phone) == false || phone.length != "10")
    {
        alert("Please enter valid 10 digit mobile number!!");
        $("#phone").focus();
        $("#phone").val("");
        return false;
    }
}
</script>
<body>

    <!--END THEME SETTING-->
 <!--
 changed some where the input field type text instead of email AND changed some where the input field type email instead of text for ticket number SMC-3460 & SMC-3461 On 22Sept2018 2:14PM
 -->   
     
  
 <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">User Profile</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <!--<li><a href="#">Extra</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>-->
                    <li class="active">User Profile</li>
                </ol>
                <div class="clearfix"></div>
            </div>  
            <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                
                 <?php 
                 
                 
echo  form_open_multipart("main/update_profile","class=form-horizontal");?>

                    <div class="col-md-12"><h2>Profile: <?php 
                                            if($studentinfo[0]->std_complete_name!="")
                                            {
                                                
                                                echo ucwords(strtolower($studentinfo[0]->std_complete_name));
                                            }
                                            else
                                            {
                                            echo ucwords(strtolower( $studentinfo[0]->std_name." ".$studentinfo[0]->std_Father_name." ".$studentinfo[0]->std_lastname   )); 
                                            }
                                            
                                            ?></h2>

                        <div class="row mtl">
                        <div class="col-md-4">
                                <div class="form-group">
                                                        <div class="thumb" align="center" style="width:28%;margin-left:28%;">

<?php if($studentinfo[0]->std_img_path==""){?>

                                                    <img src="<?php echo base_url()?>images/avtar.png"  alt="" class="img-circle"  style="height:10%;width:100%;"/>
                                                    
<?php }
else
{?>
    <img src="<?php echo base_url().'core/'?><?php echo $studentinfo[0]->std_img_path?>"  alt="" class="img-circle" style="height:10%;width:100%;"/>
<?php }?>

                    </div>

                                    <div class="text-center mbl"> 
                                    
                                     <input class="form-control" type="file" name="picture" /></br>
    
                                    <!-- <a href="<?php //echo base_url().'main/remove_profile_image'?>">-->
                                    <button type="button" class="btn btn-success" onclick="remove()" >Remove</button></a>                       
                                        
                                        
                                        
                                        </div>
                                </div>
                                <table class="table table-striped table-hover table-responsive">
                                    <tbody>
                                    <tr>
                                        <td> Name</td>
                                        <td><?php 
                                             if($studentinfo[0]->std_complete_name!="")
                                            {
                                                
                                                echo ucwords(strtolower($studentinfo[0]->std_complete_name));
                                            }
                                            else
                                            {
                                            echo ucwords(strtolower( $studentinfo[0]->std_name." ".$studentinfo[0]->std_Father_name." ".$studentinfo[0]->std_lastname   )); 
                                            }?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><?php echo  $studentinfo[0]->std_email;?></td>
                                    </tr>
                                   
                              
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-8">
                               
                                                               <div id="generalTabContent" class="tab-content">
                                    <div id="tab-edit" class="tab-pane fade in active">
                                    
                                        <form action="#" class="form-horizontal"><h3><?php echo ($this->session->userdata('usertype')=='employee')?'Organization ':'Education'; ?> Details</h3>
                                         <div class="form-group"><label class="col-sm-3 control-label"><?php echo ($this->session->userdata('usertype')=='employee')?'Employee ID':'Student PRN'; ?>&nbsp;&nbsp;<span class="mandatory">*</span></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">


                                                    <?php
                                            if(($studentinfo[0]->school_id == 'OPEN')||($studentinfo[0]->school_id == 'SWAYAM')){
                                                $readon= "";
                                            }else{$readon= "readonly";}
                                            ?>

                                                        <div class="col-xs-8"><input type="text" id="PRN" class="profile_persent form-control" name="PRN" value="<?php 
                                            echo $studentinfo[0]->std_PRN;?>" <?= $readon; ?> /><?php echo form_error('PRN', '<div class="error">', '</div>'); ?></div>
                                                
                                                    </div>
                                                </div>
                                            </div>
                                            <!--  <div class="form-group"><label class="col-sm-3 control-label">&nbsp;&nbsp;</label>
                                             
                                                     <div class="col-sm-9 controls">
                                                        <div class="row">
                                                             <div class="col-xs-8">
                                                                <div class="error">
                                                                <span class="mandatory">*&nbsp;&nbsp;</span>If you want to change PRN you have to Re-Login with changed PRN.
                                                                </div>
                                                                </div>
                                                                </div>
                                                             </div>
                                                         </div>
                                              -->

<!--span tag (mandatory) removed for College Name, Department and Branch by Pranali for SMC-4078 on 19-09-2019-->
                                            <div class="form-group"><label class="col-sm-3 control-label"><?php echo ($this->session->userdata('usertype')=='employee')?'Organization ':'College'; ?> Name&nbsp;&nbsp;</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">

                                                        <!--displayed school name from tbl_school_admin by Pranali for SMC-5137-->
                                                        <div class="col-xs-8"><input type="text" readonly id="clgname" class="profile_persent form-control"  name="clgname" value="<?php 
                                            echo @$studentinfo[0]->school_name;?>"  /><?php echo form_error('clgname', '<div class="error">', '</div>'); ?></div>

                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                           // if(($studentinfo[0]->school_id == 'OPEN')||($studentinfo[0]->school_id == 'SWAYAM')){ 
                                            ?>  
                                             <div class="form-group"><label class="col-sm-3 control-label">School ID&nbsp;&nbsp;<span class="mandatory"></span></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">

                                                        <!--displayed readonly through above condition by Pranali for SMC-5137-->
                                                        <div class="col-xs-8"><input type="text" id="school_id" class="profile_persent form-control"  name="school_id" value="<?php 
                                            echo $studentinfo[0]->school_id;?>" <?= $readon; ?> /></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php //}?>
                                               

                                            
                                               <div class="form-group"><label class="col-sm-3 control-label">Department&nbsp;&nbsp;</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">

                                                    <!-- <input type="text" id="deptname" name="deptname" value="<?php 
                                            echo $studentinfo[0]->std_dept;?>" class="form-control" /> -->
                                                        <div class="col-xs-8"><select name="deptname" id="deptname" class="profile_persent form-control"  >
                                                            <?php $dptother=array(); foreach($getalldepartment as $dptname){ $dptother[]=$dptname['Dept_Name'] ; ?>
                                                        <option value="<?php echo $dptname['Dept_Name']; ?>" <?php if($dptname['Dept_Name'] == $studentinfo[0]->std_dept){echo "selected"; } ?> ><?php echo $dptname['Dept_Name']; ?></option>
                                                    <?php } ?>
                                                    <?php if(!in_array("{$studentinfo[0]->std_dept}",$dptother)){ ?>
                                                        <option value="<?php echo $studentinfo[0]->std_dept; ?>" selected ><?php echo $studentinfo[0]->std_dept ; ?></option>
                                                    <?php } ?>
                                                    <option value="dptother" id="" name="">Other</option>
                                                    </select><?php echo form_error('deptname', '<div class="error">', '</div>'); ?></div> <div id="dpttext" style="display:none;"><input type="text" name="dptothertxt" class="col-xs-3" id="dptothertxt" style="padding:.3em;,border-radius:2px;,border-style:none;"></div><?php echo form_error('dptothertxt', '<div class="error">', '</div>'); ?>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                               <div class="form-group"><label class="col-sm-3 control-label"><?php echo ($this->session->userdata('usertype')=='employee')?'Section ':'Branch'; ?>&nbsp;&nbsp;</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">

                                                    <!-- <input type="text" id="branchname" name="branchname" value="<?php 
                                            echo $studentinfo[0]->std_branch;?>" class="form-control" /> -->

                                                        <div class="col-xs-8">
                                                        <select name="branchname" class="profile_persent form-control"  id="branchname" >
                                                        <?php $branchname=array(); foreach($getallbranch as $branch){ $branchname[]=$branch['branch_Name']; ?>
                                                        <option value="<?php echo $branch['branch_Name']; ?>" <?php if($branch['branch_Name'] == $studentinfo[0]->std_branch){echo "selected"; } ?> ><?php echo $branch['branch_Name']; ?></option>
                                                    <?php } ?>
                                                    <?php if(!in_array("{$studentinfo[0]->std_branch}",$branchname)){ ?>
                                                        <option value="<?php echo $studentinfo[0]->std_branch; ?>" selected ><?php echo $studentinfo[0]->std_branch ; ?></option>
                                                    <?php } ?>
                                                    <option value="branchother" id="" name="">Other</option>
                                                        </select>                                                        
                                                        <?php echo form_error('branchname', '<div class="error">', '</div>'); ?></div><div id="branchtext" style="display:none;"><input type="text" name="branchothertxt" class="col-xs-3" id="branchothertxt" style="padding:.3em;,border-radius:2px;,border-style:none;"></div><?php echo form_error('branchothertxt', '<div class="error">', '</div>'); ?>

                                                    </div>
                                                </div>
                                            </div>
                
                                            <?php
                                            if($this->session->userdata('usertype')=='employee')
                                            {
                                                
                                            }
                                            else
                                            {?>
                                            <div class="form-group"><label class="col-sm-3 control-label"><?php echo ($this->session->userdata('usertype')=='employee')?'Default Duration ':'Semester'; ?></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">

                                                    <!-- <input type="text" id="semester" name="semester" value="<?php if(isset($studentinfo[0]->std_semester)){
                                                             echo $studentinfo[0]->std_semester;                                                           
                                                        }else{echo ""; }?>" class="form-control" /> -->

                                                        <div class="col-xs-8">
                                                        <select name="semester" class="profile_persent form-control"  id="semester" >
                                                        <?php $semname=array(); foreach($getallsemester as $sem){ $semname[]=$sem['Semester_Name']; ?>
                                                        <option value="<?php echo $sem['Semester_Name']; ?>" <?php if(isset($studentinfo[0]->std_semester)){ if($sem['Semester_Name'] == $studentinfo[0]->std_semester){echo "selected"; }} ?> ><?php echo $sem['Semester_Name']; ?></option>
                                                    <?php } ?>
                                                    <?php if(!in_array("{$studentinfo[0]->std_semester}",$semname)){ ?>
                                                        <option value="<?php echo $studentinfo[0]->std_semester; ?>" selected ><?php echo $studentinfo[0]->std_semester ; ?></option>
                                                        <?php } ?>
                                                    <option value="semother" id="" name="">Other</option>
                                                        </select>
                                                        <?php echo form_error('semester', '<div class="error">', '</div>'); ?></div><div id="semtext" style="display:none;"><input type="text" name="semothertxt" class="col-xs-3" id="semothertxt" style="padding:.3em;,border-radius:2px;,border-style:none;"></div><?php echo form_error('semothertxt', '<div class="error">', '</div>'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                      
                                        <div class="form-group"><label class="col-sm-3 control-label"><?php echo ($this->session->userdata('usertype')=='employee')?'Financial':'Admission'; ?> Year</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">

                                                    <!-- <input type="text" id="academicyear" name="academicyear" value="<?php 
                                                        if(isset($studentinfo[0]->std_academic_year))
                                                        {
                                                            echo $studentinfo[0]->std_academic_year;   
                                                        }else{ echo ""; }?>" class="form-control" /> -->

                                                        <div class="col-xs-8">
                                                        <select name="academicyear" class="profile_persent form-control"  id="academicyear" >
                                                        <?php  $acyear=array(); foreach($getAcademicYear as $ayear){ $acyear[]=$ayear['Academic_Year']; ?>
                                                        <option value="<?php echo $ayear['Academic_Year']; ?>" <?php if(isset($studentinfo[0]->std_academic_year)){ if($ayear['Academic_Year'] == $studentinfo[0]->std_academic_year){echo "selected"; }} ?> ><?php echo $ayear['Academic_Year']; ?></option>
                                                    <?php } ?>
                                                    <?php if(!in_array("{$studentinfo[0]->std_academic_year}",$acyear)){ ?>
                                                        <option value="<?php echo $studentinfo[0]->std_academic_year; ?>" selected ><?php echo $studentinfo[0]->std_academic_year ; ?></option>
                                                        <?php } ?>
                                                        </select>     
                                                        <?php echo form_error('academicyear', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                
                                    
                                        <?php ?> <div class="form-group"><label class="col-sm-3 control-label">Gender</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                                        <?php
                                                    //  echo $studentinfo[0]->std_gender;die;
                                                        if($studentinfo[0]->std_gender=="")
                                                             
                                                            {?>
                                                        
                                                            <label class="radio-inline"><input type="radio" value="Male" name="gender" checked="checked" />&nbsp;
                                                                Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" value="Female" name="gender" />&nbsp;
                                                                Female</label>
                                                               <?php 
                                                               }
                                                               if($studentinfo[0]->std_gender=="Male"){?> 
                                                               <label class="radio-inline"><input type="radio" value="Male" name="gender" checked="checked" />&nbsp;
                                                                Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" value="Female" name="gender" />&nbsp;
                                                                Female</label>
                                                                <?php 
                                                                }
                                                                if($studentinfo[0]->std_gender=="Female"){?> 
                                                               <label class="radio-inline"><input type="radio" value="Male" name="gender"/>&nbsp;
                                                                Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" value="Female" name="gender"  checked="checked" />&nbsp;
                                                                Female</label>
                                                                <?php 
                                                                }
                                                                if($studentinfo[0]->std_gender=="F"){?> 
                                                               <label class="radio-inline"><input type="radio" value="Male" name="gender" />&nbsp;
                                                                Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" value="Female" name="gender"  checked="checked" />&nbsp;
                                                                Female</label>
                                                                <?php 
                                                                }
                                                                if($studentinfo[0]->std_gender=="M"){?> 
                                                               <label class="radio-inline"><input type="radio" value="Male" name="gender" checked="checked" />&nbsp;
                                                                Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" value="Female" name="gender" />&nbsp;
                                                                Female</label>
                                                                <?php 
                                                                }?><?php echo form_error('gender', '<div class="error">', '</div>'); ?>
                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          <?php ?>
                                        
                                        
                                        
                                            <div class="form-group"><label class="col-sm-3 control-label">Division</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                    <!-- <input type="text" id="division" name="division"  value="<?php 
                                                        if(isset($studentinfo[0]->std_div))
                                                        {
                                                             echo $studentinfo[0]->std_div; 
                                                        } ?>" class="form-control" /> -->

                                                        <div class="col-xs-8">
                                                        <select name="division" id="division" class="profile_persent form-control"  >
                                                        <?php $divname=array(); foreach($getDivision as $div){ $divname[]=$div['DivisionName']; ?>
                                                        <option value="<?php echo $div['DivisionName']; ?>" <?php if(isset($studentinfo[0]->std_div)){ if($div['DivisionName'] == $studentinfo[0]->std_div){echo "selected"; }} ?> ><?php echo $div['DivisionName']; ?></option>
                                                    <?php } ?>
                                                    <?php if(!in_array("{$studentinfo[0]->std_div}",$divname)){ ?>
                                                        <option value="<?php echo $studentinfo[0]->std_div; ?>" selected ><?php echo $studentinfo[0]->std_div ; ?></option>
                                                        <?php } ?>
                                                        <option value="divother">Other</option>
                                                        </select> 
                                                        
                                                        <?php echo form_error('division', '<div class="error">', '</div>'); ?></div><div id="divtext" style="display:none;"><input type="text" class="col-xs-3" name="divothertxt" id="divothertxt" style="padding:.3em;,border-radius:2px;,border-style:none;"></div><?php echo form_error('divothertxt', '<div class="error">', '</div>'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group"><label class="col-sm-3 control-label"><?php echo ($this->session->userdata('usertype')=='employee')?'Team':'Class'; ?></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">

                                                        <div class="col-xs-8"><input type="text" id="class" class="profile_persent form-control"  name="class" value="<?php 

//if(isset($stud_sem_record[0]->std_class))
                                                        {
                                                            echo $studentinfo[0]->std_class;
                                                            
                                                        }
                                                        /*else
                                                            
                                                            {  
echo "";                                                            
                                                             }*/?>" class="form-control" /><?php echo form_error('class', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }?>
                                           
                                            <hr/>
                                            <h3>Pro Setting</h3>

                                            <div class="form-group"><label class="col-sm-3 control-label">First Name&nbsp;&nbsp;<span class="mandatory">*</span></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8"><input type="text" class="profile_persent form-control"  placeholder="First Name"  name="fname" id="fname" value="<?php if(isset($_POST['fname'])){echo $_POST['fname'];}  else {echo $studentinfo[0]->std_name;}?>"/><?php echo form_error('fname', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-group"><label class="col-sm-3 control-label">Middle Name</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8"><input type="text" placeholder="Middle Name" class="form-control"  name="mname" id="mname" value="<?php if(isset($_POST['mname'])){echo $_POST['mname'];}  else {echo $studentinfo[0]->std_Father_name;}?>"/><?php echo form_error('mname', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-3 control-label">Last Name&nbsp;&nbsp;<span class="mandatory">*</span></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8"><input type="text" class="profile_persent form-control"  placeholder="Last Name"  name="lname" id="lname" value="<?php if(isset($_POST['lname'])){echo $_POST['lname'];} else{  echo $studentinfo[0]->std_lastname;}?>"/><?php echo form_error('lname', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                           <?php /*?> <div class="form-group"><label class="col-sm-3 control-label">Gender</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                                        <?php if($studentinfo[0]->std_gender=="")
                                                        {?>
                                                            <label class="radio-inline"><input type="radio" value="Male" name="gender" checked="checked"/>&nbsp;
                                                                Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" value="Female" name="gender"/>&nbsp;
                                                                Female</label>
                                                               <?php }if($studentinfo[0]->std_gender=="Male"){?> 
                                                               <label class="radio-inline"><input type="radio" value="Male" name="gender" checked="checked"/>&nbsp;
                                                                Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" value="Female" name="gender"/>&nbsp;
                                                                Female</label>
                                                                <?php }if($studentinfo[0]->std_gender=="Female"){?> 
                                                               <label class="radio-inline"><input type="radio" value="Male" name="gender"/>&nbsp;
                                                                Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" value="Female" name="gender"  checked="checked"/>&nbsp;
                                                                Female</label>
                                                                <?php }?><?php echo form_error('gender', '<div class="error">', '</div>'); ?>
                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          <?php */?>
                                            
                                           
                                            <hr/>
                                            <h3>Contact Details</h3>
                                             <div class="form-group"><label class="col-sm-3 control-label">Personal Email&nbsp;&nbsp;<span class="mandatory">*</span></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                                    <input type="email" placeholder="External Email" class="profile_persent form-control"   name="ext_email" id="ext_email" value="<?php if(isset($_POST['ext_email'])){echo $_POST['ext_email'];} else{  echo $studentinfo[0]->std_email;}?>"/><?php echo form_error('ext_email', '<div class="error">', '</div>'); ?>
                                                            
                                                        
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-3 control-label">Internal Email</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                                        
                                                        <input type="email" placeholder="Internal Email" class="profile_persent form-control"   name="int_email" id="int_email" value="<?php if(isset($_POST['int_email'])){echo $_POST['int_email'];} else{  echo $studentinfo[0]->Email_Internal;}?>"/><?php echo form_error('int_email', '<div class="error">', '</div>'); ?>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                                 <div class="form-group"><label class="col-sm-3 control-label">Country Code&nbsp;&nbsp;<span class="mandatory">*</span></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                                            <!-- <?php print_r($studentinfo[0]->country_code); ?> -->
                                                        <select name="country_code" id="country_code" class="profile_persent form-control" >
<!-- Select option added in Country code by Pranali for SMC-3644 -->
                                              <option value="-1">Select</option>
                                                       <?php
                                                    //    solved logic in if condition  
                                                       if(!empty($studentinfo[0]->country_code) && $studentinfo[0]->country_code!="0" && $studentinfo[0]->country_code!=" " )
                                                       {
                                                        if(($studentinfo[0]->country_code)=="91")
                                                       {?> 
                                                       
                                                       <option value="91" selected>+91</option>
                                                         <option value="1" >+1</option>
                                                       <?php }?>
                                                       
                                                         <?php if(($studentinfo[0]->country_code)=="1")
                                                       {?> 
                                                       
                                                       <option value="91" >+91</option>
                                                        <option value="1" selected >+1</option>
                                                       <?php }}
                                                       else
                                                       {
                                                       ?>
                                                         <option value="91" >+91</option>
                                                         <option value="1" >+1</option>
                                                         
                                                         <?php }?>
                                                      </select>
                                                        
                                                        <?php echo form_error('country_code', '<div class="error">', '</div>'); ?>
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group"><label class="col-sm-3 control-label">Mobile Phone&nbsp;&nbsp;<span class="mandatory">*</span></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8"><input type="text" placeholder="Mobile Phone" class="profile_persent form-control"   name="phone" id="phone" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];} else{  echo $studentinfo[0]->std_phone;}?>"/><?php echo form_error('phone', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $stdcountry= explode(',', $studentinfo[0]->std_country)[0] ?>
                                            <div class="form-group"><label class="col-sm-3 control-label">Country&nbsp;&nbsp;<span class="mandatory">*</span></label>
                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8"><select type="text" class="form-control" name="country" id="country">
                                                    <option value=""></option>
                                                    
                                                    <?php foreach($country_ar['posts'] as $res){ ?>
                                                        <option value="<?= $res["country"];?>,<?= $res["calling_id"];?>" <?php if($studentinfo[0]->std_country != ''){ if($stdcountry==$res["country"]){ echo 'selected'; } } ?> ><?= $res["country"];?></option>
                                                        <?php } ?>
                                                        </select></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-3 control-label">State&nbsp;&nbsp;<span class="mandatory">*</span></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8"><select type="text"  class="form-control" name="state" id="state">
                                                            <option value=".<?php echo $studentinfo[0]->std_city; ?>."><?php echo $studentinfo[0]->std_city; ?></option>
                                                        </select></div>
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="form-group"><label class="col-sm-3 control-label">City&nbsp;&nbsp;<span class="mandatory">*</span></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8"><select type="text"  class="form-control" name="city" id="city"  >
                                                        <option value=".<?php echo $studentinfo[0]->std_state; ?>."><?php echo $studentinfo[0]->std_state; ?></option>
                                                    </select></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            <div class="form-group"><label class="col-sm-3 control-label">Address</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8"><input type="text" placeholder="Address" class="profile_persent form-control"  name="address" id="address" value="<?php if(isset($_POST['address'])){echo $_POST['address'];} else{  echo $studentinfo[0]->std_address;}?>"/><?php echo form_error('address', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <hr/>
                                            <hr/>
                                            <h3>Password Change</h3>
                                             <div class="form-group"><label class="col-sm-3 control-label">Password&nbsp;&nbsp;<span class="mandatory">*</span></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                                    <input type="password" placeholder="Password" class="form-control" name="password" id="password" value="<?php if(isset($_POST['std_password'])){echo $_POST['std_password'];} else{  echo $studentinfo[0]->std_password;}?>"/><?php echo form_error('password', '<div class="error">', '</div>'); ?>
                                                            
                                                        
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="hdn_val" value="ko" id="hdn">
                                            <hr/>
                                            <div class="row" align="center">
                                            <div class="error" align="center">
                                                    <?php if(isset($report))
                                                    {
                                                    ?>  
                                                <font color="green"><?php //echo $report;?></font>
                                                    <?php 
                                                    }?></div>
                                              <?php 
                                                    echo form_submit('update', 'Update','class="btn btn-green" id="update" onclick="return student_pass_info();"');
                                                    ?>
                                                    &nbsp;

                                                         <a href="<?php echo site_url();?>/main/members" ><button type="button" class="btn btn-danger" onclick="return form_reset();">Cancel</button></a>
                                                    </div>
                                         <?php

echo form_close();
    ?>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END CONTENT--><!--BEGIN FOOTER-->
            <?php 


$this->load->view('footer');

?>
            <!--END FOOTER--></div>
        <!--END PAGE WRAPPER--></div>
</div>
<script>

$(document).ready(function() 
 {  
    //  state dependant on country 
    var c_id = $("#country").val();
    var cou=c_id.split(',')[0];
    var ss='<?php echo $studentinfo[0]->std_city; ?>'; 
    //alert(cou);
     $.ajax({
             type:"POST",
             data:{c_id:cou,ss:ss}, 
             url:'<?php echo base_url(); ?>/college_id/country_state_city_js.php',
             success:function(data)
             {


                 $('#state').html(data);
             }
            
             
         });
         
     $("#country").on('change',function(){   
         var cid = document.getElementById("country").value;
         //alert (cid);
         var c = cid.split(",");
         var c_id= c[0];
         $.ajax({
             type:"POST",
             data:{c_id:c_id}, 
             url:'<?php echo base_url(); ?>/college_id/country_state_city_js.php',
             success:function(data)
             {

                 $('#state').html(data);
             }
             
             
         });
         
     });
    //  city dependant on state
    $(document).ready(function() 
 {  
     var s_id = document.getElementById("state").value;
    var stu_state='<?php echo $stu_state; ?>';
    var sts='<?php echo $studentinfo[0]->std_state; ?>'; 

         $.ajax({
             type:"POST",
             data:{s_id:s_id,stu_state:stu_state,sts:sts}, 
             url:'../college_id/country_state_city_js.php',
             success:function(data)
             {
               // alert("city");
                //alert(data);
                 $('#city').html(data);
             }
             
             
         });
     $("#state").on('change',function(){     
         var s_id = document.getElementById("state").value;

         $.ajax({
             type:"POST",
             data:{s_id:s_id}, 
             url:'../college_id/country_state_city_js.php',
             success:function(data)
             {
                
                 $('#city').html(data);
             }
             
             
         });
         
     });
     
 });
     
 });
</script>
   <script>
       var dptother =document.querySelector("#deptname");
      var dpttext= document.querySelector("#dpttext");
      var branchname =document.querySelector("#branchname");
      var branchtext= document.querySelector("#branchtext");
      var semester =document.querySelector("#semester");
      var semtext= document.querySelector("#semtext");
      var division =document.querySelector("#division");
      var divtext= document.querySelector("#divtext");
      dptother.addEventListener('change',function(){
        if(dptother.value=='dptother'){
            dpttext.style.display='block';
           }
           else{
      dpttext.style.display='none';
           }
       });
       branchname.addEventListener('change',function(){
        if(branchname.value=='branchother'){
            branchtext.style.display='block';
           }
           else{
      branchtext.style.display='none';
           }
       });
       semester.addEventListener('change',function(){
        if(semester.value=='semother'){
            semtext.style.display='block';
           }
           else{
            semtext.style.display='none';
           }
       });
       division.addEventListener('change',function(){
        if(division.value=='divother'){
            divtext.style.display='block';
           }
           else{
            divtext.style.display='none';
           }
       });
    //   var persent= document.querySelectorAll(".profile_persent");
    //   var paresent_count=0;
    //    for(var i =0;i<=persent.length;i++){
    //   var valu_len=persent[i].value;
    //     if(valu_len.length >0){
    //    paresent_count++;
    //    document.querySelector("#hdn").value=paresent_count;
    //     }
    //    }
    //    </script>
       <script>
           $(document).ready(function(){
               $("#update").on('click',function(){
                //    alert("clicked");
                   var mailformat = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
                   var phn_regx=/^[0-9]*$/;
                   var fname=$("#fname").val();
                   var lname=$("#lname").val();
                   var ext_email=$("#ext_email").val();
                   var country_code=$("#country_code").val();
                   var phone=$("#phone").val();
                   var password=$("#password").val();
                   if(fname==''){
                       alert("Please Enter Your First Name !!!")
                       return false;
                   }
                   else if(lname==''){
                        alert("Please Enter Your Last Name !!!")
                        return false;
                    }
                    else if(ext_email==''){
                        alert("Please Enter Personal Email !!!")
                        
                        return false;
                    }
                    else if(!mailformat.match(ext_email)){
                        alert("Please Enter Valid Email !!!")
                        return false;
                    }
                    else if(!phn_regx.test(phone)){
                        alert("Please Enter Valid Phone Number !!!")
                        return false;
                    }
                    else if(country_code==-1){
                        alert("Please Enter Country Code !!!")

                        return false;
                    }
                    else if(phone==''){
                        alert("Please Enter Mobile Phone !!!")
                        return false;
                    }
                    else if(password==''){
                        alert("Please Enter Password !!!")
                        return false;
                    }
               })
           })
    //        var how_much_field = document.getElementById('hdn').value;
    //         var profile_persent=(how_much_field*100) / persent.length;
    //         var final_persent= Math.ceil(profile_persent);
    //         var op=  document.getElementById('iconid');
    //         console.log(op.innerHTML)
    //         op.innerHTML+= " "+final_persent + "%";
        
       </script>
         
</body>
</html> 