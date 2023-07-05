<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Add AICTE college information for 360 implementation">

    <title>College Information</title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link href="<?= base_url('core/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" >
    <link href="<?= base_url('Assets/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" >
    <link href="<?= base_url('css/bower_components/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<link href="<?= base_url('core/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" media="screen">
</head>
<body style="font-family: 'Open Sans', serif;">
<div class="container-fluid">
    <br>
	<style>
	input, select, textarea{
    color: #ff0000;
}
body{
    font-size: 16px;
    font-weight: bold;
}
/*  .prev, .next {
    display: none !important;
}
.datetimepicker-hours table{
    width: 193px;
}
.datetimepicker-minutes table{
    width: 193px;
} */
</style>
    <form id="facultyDetailsForm" action="<?= base_url('AICTEcollegeinfo/Update_Incharge_data');?>" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
            <div class="col-md-12 text-center" id="mainApplicationdiv" style="background-color: #FFFFFF;">
			 <div class="row">
        <div class="col-md-2">
      <!--image -->
	  <label for="name"><img src="<?php echo base_url('/core/Images/250_86.png');?>" height="100px"></label>
     </div>
	 <div class="col-md-2 col-md-offset-3">
      <!--image 
	  <label for="name"><img src="<?php //echo base_url('/images/pblogoname.jpg');?>" height="100px"></label>-->
     </div>
    <div class="col-md-2 col-md-offset-3">
      <!--image 
	  <label for="name"><img src="<?php// echo $GLOBALS['URLNAME']."/image/ProLogoOnly.png";?>" height="100px" width="200px"></label>-->
	  <label for="name"><img src="<?php echo base_url('/image/aicte_logo.webp');?>" height="100px" ></label>
     </div>
    </div>
			
			
			
                <div class="col-lg-12 col-md-12 form-group">
                    <h2>College Readiness for the Implementation of 360 Degree Feedback </h2>
                </div>
                <!-- <div class="col-lg-12 col-md-12 form-group">
                    <b>Basic Details of Institute</b><br> <a data-toggle="modal" data-target="#searchCollegesModal">Click here to Search your college</a>
                </div> -->
                <div class="form-group required">
                    <label for="EmploymentType" class="col-md-4 control-label">College Name:</label>
                    <div class="col-lg-8 col-md-8">
                        <?= $college_detail->college_name; ?>
                        <input type="hidden" name="clg_name" id="clg_name" value="<?= $college_detail->college_name; ?>" />
                    </div>
                </div>
                <div class="form-group required">
                    <label for="apply_id" class="col-md-4 control-label">AICTE Application ID:</label>
                    <div class="col-lg-8 col-md-8">
                        <?= $college_detail->apply_id;?>
                        <input class="form-control" name="apply_id" id="apply_id" placeholder="Enter AICTE Application ID" type="hidden" value="<?= $college_detail->apply_id;?>">
                    </div>
					
                </div>
                <div class="form-group required">
                    <label for="Name" class="col-md-4 control-label">AICTE Permanent ID:</label>
                    <div class="col-lg-8 col-md-8">
                        <?= $college_detail->aicte_id;?>
                        <input class="form-control" name="aicte_id" id="aicte_id" placeholder="Enter AICTE Permanent ID" value="<?= $college_detail->aicte_id;?>" type="hidden" >
                    </div>
					
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <label><h3>Please enter following detail for scheduling the meeting</h3></label>
    				</div>
                </div>
				<div class="row">
                    <div class="col-md-12 form-group">
                        <label class="control-label col-md-4">Role :</label>
                        <div class="col-md-8 text-left">
                            <input type="hidden" name="incharge_type" value="<?= $this->uri->segment(3);?>">
                            <?= $incharge_detail['incharge_type'];?>
                            <input type="hidden" name="type" value="<?= $incharge_detail['incharge_type'];?>">
                            <!-- <select class="form-control" required name="incharge_role">
                                <option value="erp incharge">ERP Incharge</option>
                                <option value="it incharge">IT Incharge</option>
                                <option value="aicte incharge">AICTE Co-ordinator</option>
                                <option value="tpo incharge">TPO Incharge</option>
                                <option value="art incharge">Art circle Incharge</option>
                                <option value="student incharge">Student Affairs Incharge</option>
                                <option value="admin incharge">Admin Incharge</option>
                                <option value="exam incharge">exam Incharge</option>
                                <option value="nss incharge">NSS Incharge</option>
                                <option value="sports incharge">Sports Incharge</option>
                                <option value="other">Other</option>
                                
                            </select> -->
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 form-group">
                        <label class="control-label col-md-4">Name :</label>
                        <div class="col-md-8 text-left">
                            <?= $incharge_detail['incharge_name'];?>
                            <input type="hidden" class="form-control" name="incharge_nm" value="<?= $incharge_detail['incharge_name'];?>">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 form-group">
                        <label class="control-label col-md-4">Phone No. :</label>
                        <div class="col-md-8 text-left">
                            <?= $incharge_detail['incharge_mobile'];?>
                            <input type="hidden" class="form-control" name="incharge_mob" value="<?= $incharge_detail['incharge_mobile'];?>">
                            <input type="hidden" class="form-control" name="incharge_email" value="<?= $incharge_detail['incharge_email'];?>">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 form-group">
                        <label class="control-label col-md-4">Date :</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control datepicker" autocomplete="off" name="meeting_date">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 form-group">
                        <label class="control-label col-md-4">Time :</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control timepick" autocomplete="off" name="meeting_time">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <br>
                <div class="col-md-offset-4 col-lg-2 pull-left">
                    <a href="<?= base_url();?>" class="btn btn-danger btn-block" id="BasicDetailSaveButton">Back</a>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-success btn-block" id="facultyDetailSaveButton" type="Submit">Submit</button>
                </div>
                
                <!-- <div class="col-md-4" id="facultyDetailsMessage"></div> -->
            </div>
            <!-- <br><br><b>Note:</b> The identity of the Faculty will not be revealed to the institute and will be kept confidential in the record of AICTE only. However any falsification in the above details will be viewed seriously by AICTE<br><br> -->
            <input type="hidden" name="c_id" id="c_id" value="<?= $college_detail->college_id;?>">
    </form>
</div>

</body>
    <script type="text/javascript" src="<?= base_url('Assets/js/jquery-1.10.2.min.js');?>"></script>
    <script type="text/javascript" src="<?= base_url('Assets/js/bootstrap.min.js');?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <script src="<?= base_url('core/js/bootstrap-datepicker.min.js');?>"></script>
    <script src="<?= base_url('core/js/moment.js');?>"></script>
    <script src="<?= base_url('core/js/locale/bootstrap-datetimepicker.js');?>"></script>
    <script type="text/javascript" src="<?= base_url('core/js/bootstrap-datetimepicker.fr.js');?>" charset="UTF-8"></script>
     <script type="text/javascript">
      $(document).ready(function() {
        $('.searchselect').select2();

        $('.datepicker').datepicker({
          format:'yyyy-mm-dd',
          autoClose:'TRUE',
          startDate: '-0d'
        }).on('changeDate', function(e){
        $(this).datepicker('hide');
        });
        //P added in below format for displaying AM / PM for SMC-4848 on 26-9-20
        $('.timepick').datetimepicker({
        //weekStart: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0,
        format: 'hh:ii:00',
        });
    	// $('.table-condensed .switch').html("Select Time");
      });
    </script>
    
</html>
