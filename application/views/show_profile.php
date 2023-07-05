<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head><title>User Profile</title>
    
  
</head>
<body>

    <!--END THEME SETTING-->
    
     
 
 <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">User Profile</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Extra</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">User Profile</li>
                </ol>
                <div class="clearfix"></div>
            </div>  
            <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12"><h2>Profile: <?php 
                                            echo $studentinfo[0]->std_complete_name;?></h2>

                        <div class="row mtl">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="text-center mbl"><img src="http://lorempixel.com/640/480/business/1/" alt="" class="img-responsive"/></div>
                                    <div class="text-center mbl"><a href="#" class="btn btn-green"><i class="fa fa-upload"></i>&nbsp;
                                        Upload</a></div>
                                </div>
                                <table class="table table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td> Name</td>
                                        <td><?php 
                                            echo $studentinfo[0]->std_complete_name;?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><?php echo $studentinfo[0]->std_email;?></td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td><?php echo $studentinfo[0]->std_address;?></td>
                                    </tr>
                              
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-9">
                                                               <div id="generalTabContent" class="tab-content">
                                    <div id="tab-edit" class="tab-pane fade in active">
                                        <form action="#" class="form-horizontal"><h3>Account Setting</h3>

                                            <div class="form-group"><label class="col-sm-3 control-label">Email</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="email" value="<?php 
                                            echo $studentinfo[0]->std_email;?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="form-group"><label class="col-sm-3 control-label">Password</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="password" placeholder="password" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-3 control-label">Confirm Password</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="password" placeholder="password" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                            <h3>Profile Setting</h3>

                                            <div class="form-group"><label class="col-sm-3 control-label">First Name</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="first name" class="form-control" value="<?php echo $studentinfo[0]->std_name;?>"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-3 control-label">Last Name</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="last name" class="form-control"  value="<?php echo $studentinfo[0]->std_lastname;?>"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-3 control-label">Gender</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9">
                                                            <div class="radio">
                                                             <?php if($studentinfo[0]->std_gender=='Male'){?>
                                                            <label class="radio-inline"><input type="radio" value="0" name="gender" checked="checked"/><?php }else{?><label class="radio-inline"><input type="radio" value="Male" name="gender" /><?php  }?>&nbsp;
                                                                Male</label>
                                                                
                                                                <?php if($studentinfo[0]->std_gender=='Female'){?>
                                                                <label class="radio-inline"><input type="radio" value="1" name="gender" checked="checked"/><?php }else{?><label class="radio-inline"><input type="radio" value="Female" name="gender" /><?php  }?>&nbsp;
                                                                Female</label></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-3 control-label">Birthday</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input id="datepicker-normal" type="text" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                         
                                            
                                           
                                            <hr/>
                                            <h3>Contact Setting</h3>

                                            <div class="form-group"><label class="col-sm-3 control-label">Mobile Phone</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="mobile phone" class="form-control" value="<?php echo $studentinfo[0]->std_phone?>"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-3 control-label">Address</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="Address" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <hr/>
                                            <button type="submit" class="btn btn-green btn-block">Finish</button>
                                        </form>
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
   
         
</body>
</html> 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
