<?php 
//print_r($schoolinfo);

$this->load->view('scadmin_header',$schoolinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head><title>Dashboard | Dashboard</title>
    
  
</head>
<body>

    <!--END THEME SETTING-->
    <div id="page-wrapper"><!--BEGIN SIDEBAR MENU-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Add Teacher</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active"><a href="#">Masters</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Teacher</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div id="form-layouts" class="row">
                    <div class="col-lg-12">
                      
                        <div style="background: transparent; border: 0; box-shadow: none !important" class="tab-content pan mtl mbn responsive">
                  
                         
                            <div id="tab-two-columns-horizontal" class="tab-pane fade  active in">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-black">
                                            
                                            <div class="panel-body pan">
                                                <?php 
echo form_open('main/student_register','class="form-horizontal"');?>
                                                
                                                    <div class="form-body pal"><h3>Personal</h3>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputFirstName" class="col-md-3 control-label">First Name <span class='require'>*</span></label>

                                                                    <div class="col-md-9"><input id="inputFirstName" type="text" placeholder="First Name" name="inputFirstName" class="form-control" value="<?php echo $this->input->post('inputFirstName')?>"/><?php echo form_error('inputFirstName', '<div class="error">', '</div>'); ?>
</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputLastName" class="col-md-3 control-label">Last Name <span class='require'>*</span></label>

                                                                    <div class="col-md-9" ><input id="inputLastName" type="text" placeholder="Last Name" name="inputLastName" class="form-control"/><?php echo form_error('inputLastName', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputEmail" class="col-md-3 control-label">Email <span class='require'>*</span></label>

                                                                    <div class="col-md-9">
                                                                        <div class="input-icon"><i class="fa fa-envelope"></i><input type="text" placeholder="Email Address" name="inputEmail" class="form-control"  value="<?php echo $this->input->post('inputEmail')?>"/><?php echo form_error('inputEmail', '<div class="error">', '</div>'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="selGender" class="col-md-3 control-label">Gender <span class='require'>*</span></label>

                                                                    <div class="col-md-9"><select id="selGender" class="form-control" name="selGender">
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                    </select><?php echo form_error('selGender', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                          <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputEducation" class="col-md-3 control-label">Education <span class='require'>*</span></label>

                                                                    <div class="col-md-9"><input id="inputEducation" type="text" placeholder="Education" class="form-control" name="inputEducation"/><?php echo form_error('inputEducation', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputExperience" class="col-md-3 control-label">Experience <span class='require'>*</span></label>

                                                                    <div class="col-md-9"><input id="inputExperience" type="text" placeholder="Experience" class="form-control" name="inputExperience"/><?php echo form_error('inputExperience', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputBirthday" class="col-md-3 control-label">Birthday</label>

                                                                    <div class="col-md-9"><input id="inputBirthday" type="text" placeholder="dd/mm/yyyy" class="form-control" name="inputBirthday"/></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputPhone" class="col-md-3 control-label">Phone</label>

                                                                    <div class="col-md-9"><input id="inputPhone" type="text" placeholder="" class="form-control" name="inputPhone"/></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3>Address</h3>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputAddress1" class="col-md-3 control-label">Address 1 <span class='require'>*</span></label>

                                                                    <div class="col-md-9"><input id="inputAddress1" type="text" placeholder="" class="form-control" name="inputAddress1"/><?php echo form_error('inputAddress1', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputAddress2" class="col-md-3 control-label">Address 2</label>

                                                                    <div class="col-md-9"><input id="inputAddress2" type="text" placeholder="" class="form-control" name="inputAddress2"/></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="selCountry" class="col-md-3 control-label">Country <span class='require'>*</span></label>

                                                                    <div class="col-md-9"><select id="selCountry" class="form-control" name="selCountry">
                                                                        <option value="">Select a Country</option>
                                                                         <option value="India">India</option>
                                                                        <option value="United States">United States</option>
                                                                        <option value="England">England</option>
                                                                        <option value="France">France</option>
                                                                        <option value="Spain">Spain</option>
                                                                    </select><?php echo form_error('selCountry', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                       
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputStates" class="col-md-3 control-label">State<span class="require">*</span></label>

                                                                    <div class="col-md-9"><input id="inputStates" type="text" placeholder="" class="form-control" name="inputStates"/><?php echo form_error('inputStates', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                             <div class="col-md-6">
                                                                <div class="form-group"><label for="inputCity" class="col-md-3 control-label">City <span class='require'>*</span></label>

                                                                    <div class="col-md-9"><input id="inputCity" type="text" placeholder="" class="form-control" name="inputCity"/><?php echo form_error('inputCity', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                          
                                                            
                                                              <div class="col-md-6">
                                                                <div class="form-group"><label for="inputPostCode" class="col-md-3 control-label">Post Code <span class='require'>*</span></label>
                                                                  <div class="col-md-9"><input id="inputPostCode" type="text" placeholder="" class="form-control" name="inputPostCode"/><?php echo form_error('inputPostCode', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                  
                                                    <div class="form-actions text-right pal" style="background:#FFF;">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                        &nbsp;
                                                        <a href="infostudent" style="text-decoration:none;"><button type="button" class="btn btn-green">Cancel</button></a>
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
                  <?php 


$this->load->view('footer');

?>
 
                
            <!--END CONTENT--><!--BEGIN FOOTER-->
         
            </div>
            
         
</body>
</html>